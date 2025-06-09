locals {
  name_prefix = "${var.owner}-${var.environment}"
  common_tags = {
    Owner       = var.owner
    Environment = var.environment
   
  }
  
  web_asg_name = "${local.name_prefix}-web-asg"
  alb_name = "${local.name_prefix}-alb"
  target_group_name = "${local.name_prefix}-tg"
}