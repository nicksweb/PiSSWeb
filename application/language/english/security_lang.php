<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Users Language File
 */

// Titles
$lang['security title forgot']                   = "Forgot Password";
$lang['security title login']                    = "Login";
$lang['security title profile']                  = "Profile";
$lang['security title register']                 = "Register";
$lang['security title user_add']                 = "Add User";
$lang['security title user_delete']              = "Confirm Delete User";
$lang['security title user_edit']                = "Edit User";
$lang['security title security_list']                = "Security List";
$lang['security title security_list_summary']                = "Security List - This lists zones that have been triggered while Alarm is in an Armed State";

$lang['security title arming_list']                = "Armed Zones | History";
$lang['security title arming_list_summary']                = "Arming Log - This page details when a zone has been armed / disarmed.";

$lang['security title settings']                = "Security Settings";

$lang['security title settings_summary']                = "Configure all Security related system settings for PiSS";


// Buttons
$lang['security button add_new_user']            = "Add New User";
$lang['security button register']                = "Create Account";
$lang['security button reset_password']          = "Reset Password";
$lang['security button login_try_again']         = "Try Again";

// Tooltips
$lang['security tooltip add_new_user']           = "Create a brand new user.";

// Links
$lang['security link forgot_password']           = "Forgot your password?";
$lang['security link register_account']          = "Register for an account.";

// Table Columns
$lang['security col first_name']                 = "First Name";
$lang['security col is_admin']                   = "Admin";
$lang['security col last_name']                  = "Last Name";
$lang['security col username']                   = "Username";

$lang['security col security_id']                = "ID";
$lang['security col zone']                       = "Zone";
$lang['security col status']                     = "Status";
$lang['security col logged_time']                = "LoggedTime";

$lang['security col security_id']                = "ID";
$lang['security col zone']                       = "Zone";
$lang['security col status']                     = "Status";
$lang['security col logged_time']                = "LoggedTime";


// Form Inputs
$lang['security input email']                    = "Email";
$lang['security input first_name']               = "First Name";
$lang['security input is_admin']                 = "Is Admin";
$lang['security input language']                 = "Language";
$lang['security input last_name']                = "Last Name";
$lang['security input password']                 = "Password";
$lang['security input password_repeat']          = "Repeat Password";
$lang['security input status']                   = "Status";
$lang['security input username']                 = "Username";
$lang['security input username_email']           = "Username or Email";

$lang['security input id']           = "ID";
$lang['security input zone']           = "Zone";
$lang['security input id']           = "Status";
$lang['security input id']           = "Status";

// Help
$lang['security help passwords']                 = "Only enter passwords if you want to change it.";

// Messages
$lang['security msg add_user_success']           = "%s was successfully added!";
$lang['security msg delete_confirm']             = "Are you sure you want to delete <strong>%s</strong>? This can not be undone.";
$lang['security msg delete_user']                = "You have succesfully deleted <strong>%s</strong>!";
$lang['security msg edit_profile_success']       = "Your profile was successfully modified!";
$lang['security msg edit_user_success']          = "%s was successfully modified!";
$lang['security msg register_success']           = "Thanks for registering, %s! Check your email for a confirmation message. Once
                                                 your account has been verified, you will be able to log in with the credentials
                                                 you provided.";
$lang['security msg password_reset_success']     = "Your password has been reset, %s! Please check your email for your new temporary password.";
$lang['security msg validate_success']           = "Your account has been verified. You may now log in to your account.";
$lang['security msg email_new_account']          = "<p>Thank you for creating an account at %s. Click the link below to validate your
                                                 email address and activate your account.<br /><br /><a href=\"%s\">%s</a></p>";
$lang['security msg email_new_account_title']    = "New Account for %s";
$lang['security msg email_password_reset']       = "<p>Your password at %s has been reset. Click the link below to log in with your
                                                 new password:<br /><br /><strong>%s</strong><br /><br /><a href=\"%s\">%s</a>
                                                 Once logged in, be sure to change your password to something you can
                                                 remember.</p>";
$lang['security msg email_password_reset_title'] = "Password Reset for %s";

// Errors
$lang['security error add_user_failed']          = "%s could not be added!";
$lang['security error delete_user']              = "<strong>%s</strong> could not be deleted!";
$lang['security error edit_profile_failed']      = "Your profile could not be modified!";
$lang['security error edit_user_failed']         = "%s could not be modified!";
$lang['security error email_exists']             = "The email <strong>%s</strong> already exists!";
$lang['security error email_not_exists']         = "That email does not exists!";
$lang['security error invalid_login']            = "Invalid username or password";
$lang['security error password_reset_failed']    = "There was a problem resetting your password. Please try again.";
$lang['security error register_failed']          = "Your account could not be created at this time. Please try again.";
$lang['security error user_id_required']         = "A numeric user ID is required!";
$lang['security error user_not_exist']           = "That user does not exist!";
$lang['security error username_exists']          = "The username <strong>%s</strong> already exists!";
$lang['security error validate_failed']          = "There was a problem validating your account. Please try again.";
$lang['security error too_many_login_attempts']  = "You've made too many attempts to log in too quickly. Please wait %s seconds and try again.";
