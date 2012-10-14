set :application,     "androirc.com"
set :domain,          "homer.madalynn.eu"
set :deploy_to,       "/home/web/#{application}/www"
set :user,            "web"
set :port,            2222

set :repository,      "https://github.com/androirc/website.git"
set :scm,             :git
set :branch,          "master"
set :deploy_via,      :remote_cache

set :shared_files,    ["app/config/parameters.yml"]
set :shared_children, [log_path, web_path + "/uploads"]
set :writable_dirs,   [log_path, cache_path, web_path + "/uploads"]

set :model_manager,   "doctrine"

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain                         # This may be the same as your `Web` server
role :db,         domain, :primary => true       # This is where Symfony2 migrations will run

set :keep_releases,  3

# Be more verbose by uncommenting the following line
# logger.level = Logger::MAX_LEVEL

set :use_composer,          true
set :use_sudo,              false
set :dump_assetic_assets,   true
set :update_assets_version, true
set :clear_controllers,     true
set :permission_method,     :acl

before "symfony:bootstrap:build", "deploy:set_permissions"
