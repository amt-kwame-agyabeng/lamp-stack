resource "aws_autoscaling_group" "web_asg" {
    name = local.web_asg_name
    desired_capacity = 2
    max_size = 4
    min_size = 2
    vpc_zone_identifier = var.public_subnet_ids
    launch_template {
      id = aws_launch_template.webserver.id
      version = "$Latest"
    }
  

  target_group_arns = [aws_lb_target_group.web_tg.arn]
  health_check_type = "EC2"
  health_check_grace_period = 300

  tag {
    key                 = "Name"
    value               = "${local.name_prefix}-webserver"
    propagate_at_launch = true
  }

  tag {
    key                 = "Environment"
    value               = var.environment
    propagate_at_launch = true
  }


  

  lifecycle {
    create_before_destroy = true
  }

}