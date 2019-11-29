# Instalação do Virtualbox

```bash
sudo apt-get install virtualbox
sudo apt-get install virtualbox-dkms
```

Reinicie a máquina

# Instalação do Kubectl

Baixar a mesma versão de kubectl do Kubernetes de Produção

```
curl -LO https://storage.googleapis.com/kubernetes-release/release/v1.12.9/bin/linux/amd64/kubectl
chmod +x ./kubectl
sudo mv ./kubectl /usr/local/bin/kubectl
```

# Instalação do Minukube

O minikube pode ser o da última versão, pois no momento do start, é possível passar o parâmetro "--kubernetes-version" para definir a versão do kubernetes que será instalado

```bash
curl -Lo minikube https://storage.googleapis.com/minikube/releases/latest/minikube-linux-amd64
chmod +x minikube
sudo install minikube /usr/local/bin/
rm minikube
```

# Criando máquina virtual do Minikube

Com 4 cpus e 6GB de RAM
A versão do Kubernetes precisa ser passada para ficar de acordo com a versão do ambiente de produção

```bash
minikube start --cpus 4 --memory 6000 --kubernetes-version='v1.12.9'
```

# Configurando APM no Kubernetes

## Configurando Elasticsearch

```bash
cd kubernetes
kubectl apply -f elasticsearch-persistent-volume-claim.yaml
kubectl apply -f elasticsearch-statefulset.yaml
kubectl apply -f elasticsearch-service.yaml
```

## Configurando Kibana

```bash
kubectl apply -f kibana-deployment.yaml
kubectl apply -f kibana-service.yaml
```

## Configurando APM Server

```bash
kubectl apply -f apm-server-configmap.yaml
kubectl apply -f apm-server-deployment.yaml
kubectl apply -f apm-server-service.yaml
```

# Configuração do docker para acessar minikube

Configurando docker local para os comandos serem executados no docker do minikube

```bash
eval $(minikube docker-env)
```

# Voltar configuração do docker para acessar local

Desfaz a configuração do docker local para deixar de acessar o docker do minikube e voltar a acessar o docker local

```bash
eval $(minikube docker-env -u)
```

# Expondo serviço para acessar local

```bash
kubectl -n dev port-forward svc/kibana 5601:5601
```

# Expondo serviço do apm-server para que a aplicação sem estar no kubernetes consiga enviar logs pra ela

```bash
kubectl -n dev port-forward --address 0.0.0.0 svc/apm-server 8200:8200
```
