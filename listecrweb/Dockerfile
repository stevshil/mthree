FROM almalinux:8.4

# Update system and install AWS CLI v2
RUN dnf -y update
RUN dnf -y install unzip
RUN curl "https://awscli.amazonaws.com/awscli-exe-linux-x86_64.zip" -o "/tmp/awscliv2.zip"
RUN cd /tmp; unzip /tmp/awscliv2.zip
RUN cd /tmp; ./aws/install -i /usr/local/aws-cli -b /usr/local/bin
RUN rm -rf /tmp/aws
# Install Apache and PHP
RUN dnf -y install httpd httpd-tools
RUN dnf -y module reset php
RUN dnf -y module disable php:7.2
RUN dnf -y module enable php:7.4
RUN dnf -y module install php:7.4
RUN dnf -y install php php-common php-opcache php-cli php-gd php-curl

# Update Apache to use our ECRREPO variable
RUN sed -i '/^ServerRoot/a\PassEnv ECRREPO' /etc/httpd/conf/httpd.conf
RUN sed -i '/^ServerRoot/a\PassEnv ECR_REPO' /etc/httpd/conf/httpd.conf
RUN sed -i '/^ServerRoot/a\PassEnv AWS_DEFAULT_REGION' /etc/httpd/conf/httpd.conf

# Install App
COPY index.php /var/www/html/index.php
COPY index.html /var/www/html/index.html
RUN mkdir /app
COPY start.sh /app
RUN chmod +x /app/start.sh

ENV ECRREPO=sre-course
ENV ECR_REPO='108174090253.dkr.ecr.us-east-1.amazonaws.com/sre-course​'
ENV AWS_DEFAULT_REGION='us-east-1'
ENTRYPOINT ["/app/start.sh"]
