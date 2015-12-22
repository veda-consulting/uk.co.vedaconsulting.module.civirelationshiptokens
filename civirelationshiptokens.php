<?php

require_once 'civirelationshiptokens.civix.php';

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function civirelationshiptokens_civicrm_config(&$config) {
  _civirelationshiptokens_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @param $files array(string)
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function civirelationshiptokens_civicrm_xmlMenu(&$files) {
  _civirelationshiptokens_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function civirelationshiptokens_civicrm_install() {
  _civirelationshiptokens_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function civirelationshiptokens_civicrm_uninstall() {
  _civirelationshiptokens_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function civirelationshiptokens_civicrm_enable() {
  _civirelationshiptokens_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function civirelationshiptokens_civicrm_disable() {
  _civirelationshiptokens_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed
 *   Based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function civirelationshiptokens_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _civirelationshiptokens_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function civirelationshiptokens_civicrm_managed(&$entities) {
  _civirelationshiptokens_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function civirelationshiptokens_civicrm_caseTypes(&$caseTypes) {
  _civirelationshiptokens_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function civirelationshiptokens_civicrm_angularModules(&$angularModules) {
_civirelationshiptokens_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function civirelationshiptokens_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _civirelationshiptokens_civix_civicrm_alterSettingsFolders($metaDataFolders);
}


/**
 * Implements hook_civicrm_tokens().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_tokens
 *
**/
function civirelationshiptokens_civicrm_tokens( &$tokens ) {
  $getAllRelationshipType = _civirelationshiptokens_civicrm_to_get_all_relationshipTypes();
  while ($getAllRelationshipType->fetch()) {
    $tokens['relationship']['relationship.'.$getAllRelationshipType->id.'_a_b'] =  ts($getAllRelationshipType->label_a_b);
    $tokens['relationship']['relationship.'.$getAllRelationshipType->id.'_b_a'] =  ts($getAllRelationshipType->label_b_a);
  }
}


/**
 * Implements hook_civicrm_tokens().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_tokens
 *
**/
function civirelationshiptokens_civicrm_tokenValues(&$values, $cids, $job = null, $tokens = array(), $context = null) {

  if ((array_key_exists('relationship', $tokens))) {
    $getAllRelationshipType = _civirelationshiptokens_civicrm_to_get_all_relationshipTypes();
    require_once 'CRM/Civirelationshiptokens/Utils.php';
  
    foreach($cids as $id){
      $tokenReplaceValues = CRM_Civirelationshiptokens_Utils::getRelationshipTokenReplacementValues($id, $tokens['relationship']);
      foreach ($tokens['relationship'] as $relToken) {
        $values[$id]['relationship.'.$relToken] = isset($tokenReplaceValues[$relToken]) ? $tokenReplaceValues[$relToken] : NULL;
      }//end foreach
    }//end foreach
  }//end if
}


function _civirelationshiptokens_civicrm_to_get_all_relationshipTypes() {
  return CRM_Core_DAO::executeQuery("SELECT * FROM civicrm_relationship_type");
}

