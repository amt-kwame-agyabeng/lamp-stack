# Store ASG name in SSM Parameter Store
resource "aws_ssm_parameter" "asg_name" {
  name        = "/lamp-stack/${var.environment}/asg/name"
  description = "Auto Scaling Group Name"
  type        = "String"
  value       = aws_autoscaling_group.web_asg.name
  
  tags = local.common_tags
}

# Store ALB DNS name in SSM Parameter Store
resource "aws_ssm_parameter" "alb_dns_name" {
  name        = "/lamp-stack/${var.environment}/alb/dns_name"
  description = "ALB DNS Name"
  type        = "String"
  value       = aws_lb.web_alb.dns_name
  
  tags = local.common_tags
}