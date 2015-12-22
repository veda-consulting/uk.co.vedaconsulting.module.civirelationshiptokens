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
  static function getRelationshipDetailsByContactID( $conatctID, $relTypeID ) {
    $relDetails  = array();

    if (empty($conatctID) OR empty($relTypeID)) {
      return $relDetails;
    }
    
    $relDetails = CRM_Contact_BAO_Relationship::getRelationship($conatctID
      , 3, 0, 0, 0
      , NULL, NULL
      , FALSE
      , array('relationship_type_id' => $relTypeID)
    );
    
    //FIXME : if the multiple replationship    
    // if (count($relDetails) > 1) {
    //   self::handleMultipleRelationship ( $relParams );
    // }
    return array_values($relDetails);
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
