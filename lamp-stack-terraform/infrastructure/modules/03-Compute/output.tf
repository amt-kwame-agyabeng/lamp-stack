output "alb_dns_name" {
  description = "DNS name of the application load balancer"
  value       = aws_lb.web_alb.dns_name
}

output "web_target_group_arn" {
  description = "ARN of the web server target group"
  value       = aws_lb_target_group.web_tg.arn
}