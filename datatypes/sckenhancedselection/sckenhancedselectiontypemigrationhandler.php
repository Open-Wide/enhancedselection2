<?php

class SckEnhancedSelectionTypeMigrationHandler extends DefaultDatatypeMigrationHandler {

    static public function toArray( eZContentClassAttribute $attribute ) {
        $content = $attribute->content();
        if ( empty( $content['options'] ) ) {
            unset( $content['options'] );
        }
        if ( empty( $content['delimiter'] ) ) {
            unset( $content['delimiter'] );
        }
        if ( $content['is_multiselect'] == false ) {
            unset( $content['is_multiselect'] );
        } else {
            $content['is_multiselect'] = true;
        }
        if ( empty( $content['query'] ) ) {
            unset( $content['query'] );
        }
        unset( $content['db_options'] );
        return $content;
    }

    static public function fromArray( eZContentClassAttribute $attribute, array $options ) {
        if ( array_key_exists( 'options', $options ) ) {
            foreach ( $options['options'] as $key => $value ) {
                if ( !array_key_exists( 'id', $value ) ) {
                    $options['options'][$key]['id'] = $key + 1;
                }
                if ( !array_key_exists( 'priority', $value ) ) {
                    $options['options'][$key]['priority'] = 1;
                }
            }
        }
        $content = $attribute->content();
        $content = array_merge( $content, $options );
        $attribute->setContent( $content );
    }

}
