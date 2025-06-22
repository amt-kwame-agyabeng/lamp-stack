# Simple LAMP Stack Application on AWS

This project demonstrates a simple LAMP (Linux, Apache, MySQL, PHP) stack application deployed on AWS using Terraform infrastructure as code.

# Live Demo
Access the application using the ALB DNS name output from Terraform: [lamp-dev-alb-499859236.eu-west-1.elb.amazonaws.com](http://lamp-dev-alb-499859236.eu-west-1.elb.amazonaws.com)

## Infrastructure Components

- **VPC** with public and private subnets across multiple availability zones
- **NAT Gateways** for private subnet internet access
- **Internet Gateway** for public subnet internet access
- **RDS MySQL** database for storing application data
- **EC2 instances** running in an Auto Scaling Group (min: 2, max: 4)
- **Application Load Balancer** to distribute traffic
- **Security Groups** to control access between components
- **Launch Template** with user data script for automatic application deployment

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

2. Update the `terraform.tfvars` file with your desired values, including database credentials:
   ```
   cd lamp-stack-terraform/infrastructure
   vim terraform.tfvars
   ```

3. Initialize and apply the Terraform configuration:
   ```
   terraform init
   terraform apply
   ```

## Infrastructure Architecture

The infrastructure is organized into four main Terraform modules:

1. **Networking (01-Networking)**: Creates VPC, subnets, internet gateway, NAT gateways, and route tables
2. **Security (02-Security)**: Defines security groups for web servers, database, and load balancer
3. **Compute (03-Compute)**: Provisions EC2 instances, auto scaling group, and application load balancer
4. **Database (04-Database)**: Creates RDS MySQL instance in private subnets

## Automated Application Deployment

The EC2 instances are configured with a user data script that automatically:
- Updates the system and installs required packages (Apache, PHP, Git)
- Clones the application repository
- Configures database connection settings
- Sets appropriate permissions

## High Availability and Scalability

This infrastructure is designed with the following resilience features:

- **Multi-AZ Deployment**: Resources are distributed across multiple availability zones
- **Auto Scaling**: EC2 instances automatically scale based on demand (min: 2, max: 4)
- **Load Balancing**: Traffic is distributed across healthy instances
- **Self-healing**: Unhealthy instances are automatically replaced

## Security Considerations

- Traffic is controlled through security groups with least privilege access
- Private subnets for sensitive resources like the database
- NAT Gateways for secure outbound connectivity from private subnets
- Database credentials managed securely through Terraform variables

## Testing the Infrastructure

The application is designed to test the following infrastructure components:

- Web server connectivity
- Database connectivity
- Load balancer functionality
- Auto scaling capabilities


## Monitoring, Logging & Observability

This project includes real-time monitoring, centralized logging, and observability for the LAMP stack application deployed behind a load balancer (ALB).



###  Centralized Logging

**Log Groups:**
- `apache-access-logs` — stores all HTTP requests handled by Apache.
- `apache-error-logs` — stores server-side errors from Apache.

**Log Collection:**
- **Tool:** AWS CloudWatch Agent (installed on EC2 instances)
- **Log Sources:**
  - `/var/log/apache2/access.log`
  - `/var/log/apache2/error.log`

- **Retention:** Default (logs do not expire unless manually configured)

**Sample CloudWatch Agent Config:**
```json
{
  "logs": {
    "logs_collected": {
      "files": {
        "collect_list": [
          {
            "file_path": "/var/log/apache2/access.log",
            "log_group_name": "apache-access-logs",
            "log_stream_name": "{instance_id}"
          },
          {
            "file_path": "/var/log/apache2/error.log",
            "log_group_name": "apache-error-logs",
            "log_stream_name": "{instance_id}"
          }
        ]
      }
    }
  }
}
```

## Monitoring & Alerting
Monitored Metrics via CloudWatch:

EC2 Instances: 
- CPUUtilization  
- MemoryUsedPercent
- DiskUsedPercent

Application Load Balancer (ALB):

- RequestCount - Total number of requests received by the load balancer.

- TargetResponseTime - Average time it takes for the load balancer to receive a response from the target.

- HTTPCode_ELB_5XX_Count - Number of HTTP 5xx errors returned by the load balancer.

- HTTPCode_Target_2XX_Count - Number of HTTP 2xx responses returned by the target.


###   Configured CloudWatch Alarms

The following CloudWatch alarms are active to ensure system stability and resource awareness:

| Alarm Name             | Metric               | Condition                                 | Period     | State | Action        |
|------------------------|----------------------|-------------------------------------------|------------|--------|----------------|
| HighMemoryAlertTopic   | `mem_used_percent`   | > 22% for 1 datapoint within 1 minute     | 1 minute   | OK     | Actions enabled |
| HighDiskPercentage     | `disk_used_percent`  | > 85% for 1 datapoint within 5 minutes    | 5 minutes  | OK     | Actions enabled |
| HighMemoryUsageAlarm   | `cpu_usage_user`     | > 80% for 1 datapoint within 1 minute     | 1 minute   | OK     | Actions enabled |

All alarms are currently in **OK** state and configured to trigger **SNS actions** for alert notifications when thresholds are breached.

### Performance Testing

**Tool Used:** Apache Benchmark (`ab`)

**Command Example:**
```bash
ab -n 1000 -c 100 http://lamp-dev-alb-499859236.eu-west-1.elb.amazonaws.com/
```

Observed During Load Test:

## ALB Metrics
- TargetResponseTime
- RequestCount

## Log Insights:
- Error spikes captured in apache-error-logs
- Successful requests captured in apache-access-logs

## Cleanup

To destroy the infrastructure when you're done:

```
terraform destroy
```