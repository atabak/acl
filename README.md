Dont use for production

for fuelphp 1.8 and 1.9 dev
craete new directory in package folder : acl
copy all file to package/acl/
run migration for create database table
add acl to config file for always load package


get current user id : \Acl\Acl::current_user_id();
check user access to module/controller/action : \Acl\Acl::is_access('module name', 'controller name', 'action name');

