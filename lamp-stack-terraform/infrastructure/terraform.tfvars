#-----------------------
# General variables
#-----------------------
owner       = "lampstack"
environment = "dev"
region      = "eu-west-1"

#------------------------
# Networking variables
#------------------------
vpc_cidr = "10.0.0.0/24"
vpc_name = "lamp-stack-vpc"
public_subnet_name = "lamp-stack-public-subnet"
private_subnet_name = "lamp-stack-private-subnet"
nat_eip_name = "lamp-stack-eip"
nat_gw_name = "lamp-stack-ngw"
igw_name = "lampstack-igw"
public_rt_name = "lamp-stack-public-rtb"
private_rt_name = "lamp-stack-private-rtb"


#------------------------
# Security variables 
#------------------------
web_sg_name = "lamp-stack-web-sg"
sql_sg_name = "lamp-stack-sql-sg"
alb_sg_name = "lamp-stack-alb"
http_port = 80
https_port = 443
ssh_port = 22
mysql_port = 3306

#------------------------
# Compute variables 
#------------------------

ami_id = "ami-03400c3b73b5086e9"
instance_type = "t2.micro"
key_pair_name = "lamp-stack-key"


