# General variables
owner       = "lamp"
environment = "dev"
region      = "us-east-1"

# Network variables
vpc_name           = "lamp-vpc"
vpc_cidr           = "10.0.0.0/16"
public_subnet_name = "lamp-public-subnet"
private_subnet_name = "lamp-private-subnet"
igw_name           = "lamp-igw"
nat_eip_name       = "lamp-nat-eip"
nat_gw_name        = "lamp-nat-gw"
public_rt_name     = "lamp-public-rt"
private_rt_name    = "lamp-private-rt"

# Security variables
http_port    = 80
https_port   = 443
ssh_port     = 22
mysql_port   = 3306
web_sg_name  = "lamp-web-sg"
sql_sg_name  = "lamp-sql-sg"
alb_sg_name  = "lamp-alb-sg"

# Compute variables
instance_type  = "t2.micro"
ami_id         = "ami-05328f75b2b57d32d"
key_pair_name  = "lamp-key-pair"

