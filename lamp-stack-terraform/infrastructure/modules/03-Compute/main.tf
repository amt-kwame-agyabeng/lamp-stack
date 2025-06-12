resource "aws_launch_template" "webserver" {
    name_prefix = "${local.name_prefix}-webserver"
    image_id = var.ami_id
    instance_type = var.instance_type
   
    key_name = var.key_pair_name

    vpc_security_group_ids = [var.web_sg_id]
    
    user_data = base64encode(<<-EOF
      #!/bin/bash
      yum update -y
      yum install -y httpd git php php-mysqlnd
      systemctl enable httpd
      systemctl start httpd

      # Clone the app
      cd /var/www/html
      git clone https://github.com/amt-kwame-agyabeng/simple-lamp-stack.git

      # Move the contents up
      cp -r simple-lamp-stack/* .
      cp simple-lamp-stack/.env.example .env

      # Overwrite .env with correct credentials
      cat <<EOT > .env
      DB_HOST=${var.db_host}
      DB_NAME=${var.db_name}
      DB_USER=${var.db_user}
      DB_PASSWORD=${var.db_password}
      EOT

      # Set correct ownership and permissions
      chown -R apache:apache /var/www/html
      chmod 644 .env

      # Optional: clean up
      rm -rf simple-lamp-stack
    EOF
    )
   
    tag_specifications {
        resource_type = "instance"
        tags = merge(local.common_tags, {
            Name = "${local.name_prefix}-webserver"
        })
    }
  
    lifecycle {
      create_before_destroy = true
    }
}

resource "aws_lb" "web_alb" {
    name = local.alb_name
    internal = false
    load_balancer_type = "application"
    subnets = var.public_subnet_ids
    security_groups = [var.alb_sg_id]
    drop_invalid_header_fields = true
    enable_deletion_protection = var.environment == "prod" ? true : false

    tags = merge(local.common_tags, {
        Name = local.alb_name
    })
}

resource "aws_lb_listener" "http_listener" {
    load_balancer_arn = aws_lb.web_alb.arn
    port              = 80
    protocol          = "HTTP"

    default_action {
      type             = "forward"
      target_group_arn = aws_lb_target_group.web_tg.arn
    }
}

resource "aws_lb_target_group" "web_tg" {
    name        = local.target_group_name
    port        = 80
    protocol    = "HTTP"
    vpc_id      = var.vpc_id
    target_type = "instance"

    health_check {
      path                = "/info.php"
      interval            = 30
      timeout             = 10
      healthy_threshold   = 2
      unhealthy_threshold = 5
      matcher             = "200-399"
    }

    lifecycle {
      create_before_destroy = true
    }

    tags = merge(local.common_tags, {
      Name = local.target_group_name
    })
}