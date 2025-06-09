resource "aws_ssm_parameter" "sg_web_id" {
  name        = "/lamp-stack/${var.environment}/sg/web/id"
  description = "Web Server Security Group ID"
  type        = "String"
  value       = aws_security_group.web_sg.id
  
  tags = local.common_tags
}

resource "aws_ssm_parameter" "sg_sql_id" {
  name        = "/lamp-stack/${var.environment}/sg/db/id"
  description = "Database Security Group ID"
  type        = "String"
  value       = aws_security_group.sql_sg.id
  
  tags = local.common_tags
}

resource "aws_ssm_parameter" "sg_alb_id" {
  name        = "/lamp-stack/${var.environment}/sg/alb/id"
  description = "ALB Security Group ID"
  type        = "String"
  value       = aws_security_group.alb_sg.id
  
  tags = local.common_tags
}