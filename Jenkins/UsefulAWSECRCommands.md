# Get account ID

```
AccountID=$(aws sts get-caller-identity | grep Account | sed -e 's/^.*: "//' -e 's/".*//')
```

# Log in to AWS ECR using AWS CLI container, pass credentials to Docker container to push images

```
stages {
  stage('Promote to Production') {
    steps {
      container(name: 'awscli') {
        sh '''
        export AWS_DEFAULT_REGION=us-east-1
        aws ecr-public get-login-password >ecrpw
'''
      }
      container(name: 'docker') {
        script {
          buildNumber = Jenkins.instance.getItem('sre- orderbook').getItem('steve').lastSuccessfulBuild.number
      }
        sh '''
        echo "LAST Build: ''' + buildNumber + '''"
        cat ecrpw | docker login --username AWS --password-stdin ${ECR_REPO}
        docker tag ${ECR_REPO}/c0k5g8z4/sre-course:orderbookapi-dev-''' + buildNumber +''' ${ECR_REPO}/c0k5g8z4/sre-course:orderbookapi-prod-''' + buildNumber +'''
  '''
      }
    }
  }
}
```

# Pipeline agents using kubernetes podTemplate

```
agent {
    kubernetes {
        yaml """\
    apiVersion: v1
    kind: Pod
    metadata:
      labels:
        some-label: some-label-value
    spec:
      containers:
      - name: awscli
        image: amazon/aws-cli
        command:
        - cat
        tty: true
      - name: docker
        image: docker:dind
        command:
        - cat
        tty: true
    """.stripIndent()
    }
}
```
