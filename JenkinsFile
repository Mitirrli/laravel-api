pipeline {
    agent any

    stages {
        stage('拉取 代码'){
            steps {
                echo "拉取 ${gitlabBranch} 分支的代码"

                checkout([$class: 'GitSCM', branches: [[name: "*/${gitlabBranch}"]], doGenerateSubmoduleConfigurations: false, extensions: [], submoduleCfg: [], userRemoteConfigs: [[credentialsId: "${credentialsId}", url: "${REPOSITORY}"]]])

                echo "拉取 环境变量"
                sh """
                    cp -f ".env.${gitlabBranch}" .env
                """

                echo "安装 composer"
                sh """
                    export COMPOSER_HOME="/root/.config/composer"

                    composer i --dev --ignore-platform-reqs
                """
            }
        }

        stage('镜像 部署'){
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
    }

    // 流水线结束通知
    post {
        // 成功通知
        success {
            dingtalk (
                robot: "${ROBOT}",
                type: 'MARKDOWN',
                at: [''],
                atAll: false,
                text: [
                    "# 🐳 ${APPLICATION}",
                    '---',
                    "> 构建信息:",
                    "",
                    "构建应用:<font color='#000000'>${APPLICATION}</font>",
                    "",
                    "构建类型:<font color='#000000'>${gitlabActionType}</font>",
                    "",
                    "构建环境:<font color='#000000'>${gitlabBranch}</font>",
                    "",
                    "构建分支:<font color='#000000'>${commitTag}</font>",
                    "",
                    "构建编号:<font color='#000000'>${BUILD_NUMBER}</font>",
                    "",
                    "构建用户:<font color='#000000'>${gitlabUserName}</font>",
                    "",
                    "构建详情:<font color='#000000'>${commitMsg}</font>",
                    "",
                    "任务日志:[打开控制台](${RUN_DISPLAY_URL})"
                ],
                messageUrl: "${env.BUILD_URL}",
            )
        }
    }
}
