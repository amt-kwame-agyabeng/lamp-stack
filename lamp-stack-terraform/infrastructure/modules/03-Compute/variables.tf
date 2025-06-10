variable "owner" {
    description = "Owner of the resources"
    type = string
}

variable "environment" {
    description = "The environment of the project"
    type = string
}

variable "region" {
    description = "The region of your VPC"
    type = string
}

variable "instance_type" {
    description = "The instance type of the instances"
    type = string
}

variable "ami_id" {
    description = "The AMI ID"
    type = string
}

variable "key_pair_name" {
    description = "The name of the key pair to use for SSH access"
    type = string
}

variable "vpc_id" {
    description = "The ID of the VPC"
    type = string
}

variable "public_subnet_ids" {
    description = "List of public subnet IDs"
    type = list(string)
}

variable "private_subnet_ids" {
    description = "List of private subnet IDs"
    type = list(string)
}

variable "web_sg_id" {
    description = "Web server security group ID"
    type = string
}

variable "alb_sg_id" {
    description = "ALB security group ID"
    type = string
}

