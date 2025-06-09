output "alb_sg_id" {
  description = "ID of the ALB security group"
  value       = aws_security_group.alb_sg.id
}

output "web_sg_id" {
  description = "ID of the web server security group"
  value       = aws_security_group.web_sg.id
}

output "sql_sg_id" {
  description = "ID of the database server security group"
  value       = aws_security_group.sql_sg.id
}