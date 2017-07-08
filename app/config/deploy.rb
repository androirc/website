require 'net/ssh/proxy/command'

set :stages, %w(preprod prod)
set :default_stage, "preprod"
set :stage_dir, "app/config"
require 'capistrano/ext/multistage'

load 'app/config/deploy.config.rb'

set :application,     "androirc.com"
default_run_options[:pty] = true
set :repository,      "https://github.com/androirc/website.git"
set :scm,             :git
set :deploy_via,      :remote_cache

set :default_shell,   "sudo -E -H -u #{webserver_user} /bin/bash"

set :default_environment, {
  'COMPOSER_HOME' => "/var/www/#{application}/composer"
}

set :ssh_options, {
    config: false,
    proxy: Net::SSH::Proxy::Command.new("ssh #{ssh_proxy} -W %h:%p"),
    port: 22
}

set :shared_files,    ["app/config/parameters.yml"]
set :shared_children, [log_path, web_path + "/uploads"]
set :writable_dirs,   [log_path, cache_path, web_path + "/uploads"]

set :model_manager,   "doctrine"

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain                         # This may be the same as your `Web` server
role :db,         domain, :primary => true       # This is where Symfony2 migrations will run

set :keep_releases,  3

# Be more verbose by uncommenting the following line
logger.level = Logger::INFO

set :use_composer,          true
set :use_sudo,              false
set :dump_assetic_assets,   true
set :update_assets_version, true
set :clear_controllers,     true

# Permissions
set :permission_method,   :acl
set :use_set_permissions, true

before "symfony:bootstrap:build", "deploy:set_permissions"
