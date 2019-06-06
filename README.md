# Laravel setup

## Depends on 

- [Ansible](https://www.ansible.com/)
- [Vagrant](https://www.vagrantup.com/)
- [VirtualBox](https://www.virtualbox.org/)


- [Ansible-Galaxy](https://galaxy.ansible.com/)
``` console
ansible-galaxy install -fr playbooks/requirements.yml
```

## Install

```console
cd playbooks
vagrant up --provision
```

## SSH

```console
ssh <github-username>@192.168.33.11
```

## Check

- <http://192.168.33.11>

## Encrypt password
- `playbooks/vars/`
    - `dev.yml`
    - `staging.yml`
    - `production.yml`
    - `secrets.yml`

- encrypt: `ansible-vault encrypt vars/secrets.yml`
- decrypt: `ansible-vault decrypt vars/secrets.yml`

## Deploy
- dev
    - `vagrant up --provision`

- staging
    - `ansible-playbook site.yml -i inventories/staging/hosts --ask-vault-pass`

- production
    - `ansible-playbook site.yml -i inventories/production/hosts --ask-vault-pass`
