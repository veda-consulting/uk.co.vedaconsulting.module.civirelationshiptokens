<?php 

/**
 * Civirelationshiptokens Utils functionalities
 *
 */
 
class CRM_Civirelationshiptokens_Utils {
  
  /**
   * To get relationship detials by relationshipType ID 
   *
   */
  static function getRelationshipDetailsByContactID( $contactID, $relTypeID ) {
    $relDetails  = array();

    if (empty($contactID) OR empty($relTypeID)) {
      return $relDetails;
    }
    

    $aParams = array(
      'conatct_id' => $contactID,
      'relationship_type_id' => $relTypeID,
      'is_active' => 1,
      'sequential' => 1,
    );
    $relDetails = civicrm_api3('Relationship', 'get', $aParams);
    
    //FIXME : if the multiple replationship    
    // if (count($relDetails) > 1) {
    //   self::handleMultipleRelationship ( $relParams );
    // }
    return $relDetails['values'];
  }
  
  
  /**
   * To get Token Replacement Values
   *
   */
  static function getRelationshipTokenReplacementValues($conatctID, $tokens) {
    if (empty($conatctID) OR CRM_Utils_Array::crmIsEmptyArray($tokens)) {
      return array();
    }

    
    $tokenArray   = self::_toRearrangeTokenArray($tokens);
    $replaceArray = array();

    foreach ($tokenArray as $relTypeID => $value) {
      $relValues = self::getRelationshipDetailsByContactID( $conatctID, $relTypeID );
      foreach ($value as $targetContact => $tokenId ) {
        $replaceArray[$tokenId] = $relValues[0]['contact_id_'.$targetContact];
      }
    }

    return $replaceArray;
  }
  
  //to rearrange the array values
  static function _toRearrangeTokenArray($tokens) {
    
    $tokenArray = array();
    if (CRM_Utils_Array::crmIsEmptyArray($tokens)) {
      return $tokenArray;
    }
    
    foreach ($tokens as $key => $value) {
      $explodedValues = explode('_', $value);
      $tokenArray[$explodedValues[0]][$explodedValues[2]] = $value;
    }
    
    return $tokenArray;
  }
  
  
    
  /**
   * To get Contact name
   *
   */
  static function getContactDisplayName ( $contactID ) {
    return CRM_Contact_BAO_Contact::displayName($contactID);
  }
  
  /**
   * To manage , if contact has mutiple relationship with single relationship type 
   * Return Current relationship, ( by created date / active )
   *
   */
  static function handleMultipleRelationship ( $relParams ) {
    // NEED TO FIX , if mutiple relationship
    return $currentRelValues;
  }
} // end class
