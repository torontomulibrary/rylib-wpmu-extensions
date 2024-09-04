<?php
function tmu_wpmu_is_admin() {
  return is_multisite() && current_user_can('manage_network_options') || !is_multisite() && current_user_can('manage_options');
}