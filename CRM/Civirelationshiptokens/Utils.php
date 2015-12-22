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
      'contact_id' => $contactID,
      'relationship_type_id' => $relTypeID,
      'is_active' => 1,
      'sequential' => 1,
    );
    $relDetails = civicrm_api3('Relationship', 'get', $aParams);

    return $relDetails['values'];
  }
  
  
  /**
   * To get Token Replacement Values
   *
   */
  static function getRelationshipTokenReplacementValues($contactID, $tokens) {
    if (empty($contactID) OR CRM_Utils_Array::crmIsEmptyArray($tokens)) {
      return array();
    }

    
    $tokenArray   = self::_toRearrangeTokenArray($tokens);
    $replaceArray = array();

    foreach ($tokenArray as $relTypeID => $value) {
      $relValues = self::getRelationshipDetailsByContactID( $contactID, $relTypeID );
      if (!empty($relValues)) {
        foreach ($value as $targetContact => $tokenId ) {
          $replaceArray[$tokenId] = self::getContactDisplayName ( $relValues[0]['contact_id_'.$targetContact] );
          // in case of multiple relationship in single relationship type
          if (count($relValues) > 1) {
            foreach ($relValues as $key => $relationships) {
              $allRelatedContact[$relationships['id']] = self::getContactDisplayName ( $relationships['contact_id_'.$targetContact] );
            }
            $replaceArray[$tokenId] = implode(', ', array_unique($allRelatedContact));
          }
        }
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

} // end class
