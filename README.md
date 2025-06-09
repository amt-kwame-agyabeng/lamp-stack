# AWS LAMP Stack Infrastructure

This repository contains Terraform code for deploying a highly available and scalable LAMP (Linux, Apache, MySQL, PHP) stack on AWS, following AWS Well-Architected Framework principles.

## Architecture Overview

The infrastructure is designed with the following components:

- **Networking Layer**: Multi-AZ VPC with public and private subnets
- **Security Layer**: Properly configured security groups for web, database, and load balancer
- **Compute Layer**: Auto Scaling Group for web servers with Application Load Balancer
- **Database Layer**: MySQL database server in private subnet

### Architecture Diagram

```
                                   ┌─────────────────────────────────────────────┐
                                   │                  AWS Cloud                  │
                                   │                                             │
                                   │  ┌─────────────────────────────────────┐    │
                                   │  │               VPC                   │    │
                                   │  │                                     │    │
┌─────────┐                        │  │  ┌─────────────┐   ┌─────────────┐  │    │
│         │                        │  │  │  Public     │   │  Public     │  │    │
│ Users   │ ───────────────────────┼──┼─▶│  Subnet AZ1 │   │  Subnet AZ2 │  │    │
│         │                        │  │  │             │   │             │  │    │
└─────────┘                        │  │  │  ┌─────┐    │   │  ┌─────┐    │  │    │
                                   │  │  │  │ ALB ├────┼───┼──┤ ALB │    │  │    │
                                   │  │  │  └──┬──┘    │   │  └──┬──┘    │  │    │
                                   │  │  │     │       │   │     │       │  │    │
                                   │  │  │  ┌──▼──┐    │   │  ┌──▼──┐    │  │    │
                                   │  │  │  │ Web │    │   │  │ Web │    │  │    │
                                   │  │  │  │ ASG │    │   │  │ ASG │    │  │    │
                                   │  │  │  └──┬──┘    │   │  └──┬──┘    │  │    │
                                   │  │  └─────┼───────┘   └─────┼───────┘  │    │
                                   │  │        │                 │          │    │
                                   │  │  ┌─────▼───────┐   ┌─────▼───────┐  │    │
                                   │  │  │  Private    │   │  Private    │  │    │
                                   │  │  │  Subnet AZ1 │   │  Subnet AZ2 │  │    │
                                   │  │  │             │   │             │  │    │
                                   │  │  │  ┌─────┐    │   │  ┌─────┐    │  │    │
                                   │  │  │  │ DB  │    │   │  │ DB  │    │  │    │
                                   │  │  │  └─────┘    │   │  └─────┘    │  │    │
                                   │  │  └─────────────┘   └─────────────┘  │    │
                                   │  │                                     │    │
                                   │  └─────────────────────────────────────┘    │
                                   │                                             │
                                   └─────────────────────────────────────────────┘
```

## Well-Architected Framework Principles

This infrastructure follows AWS Well-Architected Framework principles:

### 1. Operational Excellence
- Infrastructure as Code (IaC) using Terraform
- Modular architecture for easier maintenance
- Consistent tagging strategy

### 2. Security
- Network segmentation with public and private subnets
- Security groups with least privilege access
- SSH access restricted to necessary instances

### 3. Reliability
- Multi-AZ deployment for high availability
- Auto Scaling Group for web tier
- Health checks and automatic recovery

### 4. Performance Efficiency
- Application Load Balancer for efficient traffic distribution
- Properly sized instances based on workload requirements
- Scalable architecture that can grow with demand

### 5. Cost Optimization
- Auto Scaling to match capacity with demand
- Appropriate instance types for workload
- Resource tagging for cost allocation

## Infrastructure Components

### 1. Networking (01-Networking)
- VPC with CIDR block as defined in variables
- 2 Public subnets across different AZs
- 2 Private subnets across different AZs
- Internet Gateway for public internet access
- NAT Gateways for private subnet internet access
- Route tables for traffic management

### 2. Security (02-Security)
- Web server security group allowing HTTP, HTTPS, and SSH
- Database security group allowing MySQL access only from web servers
- ALB security group allowing HTTP and HTTPS from internet

### 3. Compute (03-Compute)
- Launch template for web servers with Apache and PHP
- Auto Scaling Group for web servers with desired capacity of 2
- Application Load Balancer for distributing traffic
- Database server in private subnet

## Deployment Instructions

### Prerequisites
- AWS CLI configured with appropriate credentials
- Terraform installed (v1.0.0 or newer)
- SSH key pair for accessing instances

### Deployment Steps

1. Clone this repository:
   ```
   git clone <repository-url>
   cd lamp-stack
   ```

2. Navigate to the infrastructure directory:
   ```
   cd lamp-stack-terraform/infrastructure
   ```

3. Initialize Terraform:
   ```
   terraform init
   ```

4. Review and customize the `terraform.tfvars` file with your specific values.

5. Plan the deployment:
   ```
   terraform plan
   ```

6. Apply the configuration:
   ```
   terraform apply
   ```

7. After deployment, access the web application via the ALB DNS name (available in Terraform outputs).

## LAMP Stack Configuration

### Web Server Configuration
The web servers are automatically configured with:
- Apache web server
- PHP 
- Sample index.html and info.php pages

### Database Server Configuration
After deployment, connect to the database server via SSH and run:

```bash
# Install MySQL
sudo yum update -y
sudo yum install -y mariadb-server
sudo systemctl start mariadb
sudo systemctl enable mariadb

# Secure MySQL installation
sudo mysql_secure_installation

# Create database and user
mysql -u root -p
CREATE DATABASE lampapp;
CREATE USER 'lampuser'@'%' IDENTIFIED BY 'your_secure_password';
GRANT ALL PRIVILEGES ON lampapp.* TO 'lampuser'@'%';
FLUSH PRIVILEGES;
EXIT;
```

## Connecting Web Application to Database

To connect your PHP application to the MySQL database:

1. Create a database connection file (e.g., `db_connect.php`):

```php
<?php
$servername = "private_ip_of_db_server";
$username = "lampuser";
$password = "your_secure_password";
$dbname = "lampapp";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>
```

2. Upload this file to your web servers.

## Scaling Considerations

This infrastructure is designed to scale automatically:

- **Horizontal Scaling**: The Auto Scaling Group will add or remove web servers based on demand.
- **Vertical Scaling**: Instance types can be modified in the variables file for more CPU/memory.



## Security Best Practices

- Restrict SSH access to specific IP ranges in production
- Implement AWS WAF with the ALB for additional security
- Enable encryption for data in transit and at rest
- Rotate database credentials regularly

## Cleanup

To destroy the infrastructure when no longer needed:

```
terraform destroy
```

