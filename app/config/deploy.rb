set :stages, %w(preprod prod)
set :default_stage, "preprod"
set :stage_dir, "app/config"
require 'capistrano/ext/multistage'

set :application,     "androirc.com"
set :domain,          "homer.madalynn.eu"
set :user,            "web"
default_run_options[:pty] = true
set :repository,      "https://github.com/androirc/website.git"
set :scm,             :git
set :deploy_via,      :remote_cache

set :ssh_options, {
    config: false,
    port: 2222
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
set :permission_method,     false

before "symfony:bootstrap:build", "deploy:set_permissions"
