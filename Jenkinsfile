pipeline {
    agent any

    stages {
        stage('代码 拉取') {
            steps {
                echo "拉取 ${gitlabBranch} 分支的代码"
                checkout([$class: 'GitSCM', branches: [[name: "*/${gitlabBranch}"]], doGenerateSubmoduleConfigurations: false, extensions: [], submoduleCfg: [], userRemoteConfigs: [[credentialsId: "${credentialsId}", url: "${REPOSITORY}"]]])

                echo "拉取 子模块"
                sh """
                    git submodule init && git submodule update
                """

                echo "拉取 环境变量"
                sh """
                    cp -f ".env.${gitlabBranch}" .env
                """

                echo "替换mysql redis地址为外网地址"
                sh """
                    sed -i 's/r-bp17f27en7xjhvedny.redis.rds.aliyuncs.com/r-bp17f27en7xjhvednypd.redis.rds.aliyuncs.com/g' .env
                    sed -i 's/rm-bp15p803jpar70pbj125010.mysql.rds.aliyuncs.com/rm-bp15p803jpar70pbjgo.mysql.rds.aliyuncs.com/g' .env
                """

                echo "安装 依赖"
                sh """
                    docker exec laravel-api composer i --ignore-platform-reqs
                """

                echo "数据 迁移"
                sh """
                    docker exec laravel-api php artisan migrate
                """

                echo "覆盖 外网地址"
                sh """
                    cp -f ".env.${gitlabBranch}" .env
                """
            }
        }

        stage('镜像 推送') {
            steps {
                script {
                    commitTemp = sh returnStdout: true, script: 'git describe --tags --always --dirty="-dev"'
                    commitTag = commitTemp.minus("\n")
                    commitMsg = sh returnStdout: true, script: 'git log --pretty=format:"%s" -1'
                }

                sh """
                    docker build  -t "${IMAGE_REPO}/${NAMESPACE}/${APPLICATION}:${commitTag}" .
                    docker login -u ${IMAGE_USER} -p \"${IMAGE_PASS}\" ${IMAGE_REPO}
                    docker push ${IMAGE_REPO}/${NAMESPACE}/${APPLICATION}:${commitTag}
                """
            }
        }

        stage('容器 部署') {
            steps {
                sh """
                    curl -X PATCH \
                        -H "content-type: application/strategic-merge-patch+json" \
                        -H "Authorization:Bearer eyJhbGciOiJSUzI1NiIsImtpZCI6Ind0cXJSSjRBRlA1NGRSQXJxWlR1dWRMdUJ5Mms5ZUVleGJYZGFUSTBaUlkifQ.eyJpc3MiOiJrdWJlcm5ldGVzL3NlcnZpY2VhY2NvdW50Iiwia3ViZXJuZXRlcy5pby9zZXJ2aWNlYWNjb3VudC9uYW1lc3BhY2UiOiJrdWJlLXN5c3RlbSIsImt1YmVybmV0ZXMuaW8vc2VydmljZWFjY291bnQvc2VjcmV0Lm5hbWUiOiJrdWJvYXJkLXVzZXItdG9rZW4tcWgyd2wiLCJrdWJlcm5ldGVzLmlvL3NlcnZpY2VhY2NvdW50L3NlcnZpY2UtYWNjb3VudC5uYW1lIjoia3Vib2FyZC11c2VyIiwia3ViZXJuZXRlcy5pby9zZXJ2aWNlYWNjb3VudC9zZXJ2aWNlLWFjY291bnQudWlkIjoiMjUwNDkxYTItZmU0YS00MDZjLTk3YWQtMDNlNjcwYzU0MWFmIiwic3ViIjoic3lzdGVtOnNlcnZpY2VhY2NvdW50Omt1YmUtc3lzdGVtOmt1Ym9hcmQtdXNlciJ9.sSkH49Roo7cnYtwcS4_9XI-17m3cdiheB7QnoojhOMjKMmrqXd8RNe_M-o4da_M69pdAHzrLq91qacjlleOWv5-dtwrNxbYd8ZFAGQlHVTVy7mPalaysq2ngzNQrSSsboVCMNhtXrG8xdJJwBQVv2UJAnimH90WU2YOOlf0h_2o8bDi_OpBCcN-okTdK2qWkpjKQd4hWIBkpi-0-RC3vnNITtUrazLIQUyeq-qZOuJnTbMkHx3rz6apGbAQar13WaBL-HHM3GdjFjlm5vULEdzRTKkwIbnHY6KZ8ngz32upfxdBpb004PP3Lhu7hhbztt5UUVHRgBK1lMJb0AJ_4gQ" \
                        -d '{"spec":{"template":{"spec":{"containers":[{"name":"code","image":"registry-vpc.cn-hangzhou.aliyuncs.com/back-code/yxb2:${commitTag}"}]}}}}' \
                        "http://47.111.234.205:32567/k8s-api/apis/apps/v1/namespaces/back-code/deployments/yxb2-${gitlabBranch}"
                """
            }
        }
    }

    post {
        success {
            dingtalk (
                robot: "${ROBOT}",
                type: 'MARKDOWN',
                at: [''],
                atAll: false,
                text: [
                    "# 🐳 药械帮 2.0",
                    '---',
                    "构建应用: <font color='#000000'>${APPLICATION}</font>",
                    "",
                    "构建类型: <font color='#000000'>${gitlabActionType}</font>",
                    "",
                    "构建环境: <font color='#000000'>${gitlabBranch}</font>",
                    "",
                    "构建分支: <font color='#000000'>${commitTag}</font>",
                    "",
                    "构建编号: <font color='#000000'>${BUILD_NUMBER}</font>",
                    "",
                    "构建用户: <font color='#000000'>${gitlabUserName}</font>",
                    "",
                    "构建详情: <font color='#000000'>${commitMsg}</font>",
                    "",
                    "任务日志:[打开控制台](${RUN_DISPLAY_URL})"
                ],
                messageUrl: "${env.BUILD_URL}",
            )
        }
    }
}
