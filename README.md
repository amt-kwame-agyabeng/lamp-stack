# Simple LAMP Stack Application on AWS

This project demonstrates a simple LAMP (Linux, Apache, MySQL, PHP) stack application deployed on AWS using Terraform infrastructure as code.

## Infrastructure Components

- **VPC** with public and private subnets across multiple availability zones
- **NAT Gateways** for private subnet internet access
- **Internet Gateway** for public subnet internet access
- **RDS MySQL** database (manually created in AWS Management Console) for storing application data
- **EC2 instances** running in an Auto Scaling Group (min: 2, max: 4)
- **Application Load Balancer** to distribute traffic
- **Security Groups** to control access between components
- **Launch Template** for consistent EC2 instance configuration

## Application

The application is a simple PHP page that:

- Connects to a MySQL database
- Displays a successful database connection message
- Tracks and displays the total number of visits to the page

## Deployment Instructions

1. Configure your AWS credentials:
   ```
   aws configure
   ```

2. Create an RDS MySQL database instance in the AWS Management Console.

3. Update the `terraform.tfvars` file with your desired values:
   ```
   cd lamp-stack-terraform/infrastructure
   vim terraform.tfvars
   ```

4. Initialize and apply the Terraform configuration:
   ```
   terraform init
   terraform apply
   ```

5. Configure your application to connect to the manually created RDS database.

6. Access the application using the ALB DNS name output from Terraform.

## Infrastructure Architecture

The infrastructure is organized into three main Terraform modules:

1. **Networking (01-Networking)**: Creates VPC, subnets, internet gateway, NAT gateways, and route tables
2. **Security (02-Security)**: Defines security groups for web servers, database, and load balancer
3. **Compute (03-Compute)**: Provisions EC2 instances, auto scaling group, and application load balancer

## High Availability and Scalability

This infrastructure is designed with the following resilience features:

- **Multi-AZ Deployment**: Resources are distributed across multiple availability zones
- **Auto Scaling**: EC2 instances automatically scale based on demand (min: 2, max: 4)
- **Load Balancing**: Traffic is distributed across healthy instances
- **Self-healing**: Unhealthy instances are automatically replaced

## Security Considerations

- Traffic is controlled through security groups with least privilege access
- Private subnets for sensitive resources
- NAT Gateways for secure outbound connectivity from private subnets

## Testing the Infrastructure

The application is designed to test the following infrastructure components:

- Web server connectivity
- Database connectivity
- Load balancer functionality
- Auto scaling capabilities

## Cleanup

To destroy the infrastructure when you're done:

```
terraform destroy
```

Note: Remember to manually delete the RDS database instance from the AWS Management Console as it was created outside of Terraform.