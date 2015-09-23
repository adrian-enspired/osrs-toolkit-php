<?php

namespace OpenSRS\trust;

use OpenSRS\trust\UpdateProduct;
/**
 * @group trust
 * @group trust\UpdateProduct
 */
class UpdateProductTest extends \PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'attributes' => array(
            'product_id' => '',
            ),
        );

    /**
     * Valid submission should complete with no
     * exception thrown
     *
     * @return void
     *
     * @group validsubmission
     */
    public function testValidSubmission() {
        $data = json_decode( json_encode($this->validSubmission) );

        $data->attributes->product_id = time();


        $ns = new UpdateProduct( 'array', $data );

        $this->assertTrue( $ns instanceof UpdateProduct );
    }

    /**
     * Data Provider for Invalid Submission test
     */
    function submissionFields() {
        return array(
            'missing product_id' => array('product_id'),
            );
    }

    /**
     * Invalid submission should throw an exception
     *
     * @return void
     *
     * @dataProvider submissionFields
     * @group invalidsubmission
     */
    public function testInvalidSubmissionFieldsMissing( $field, $parent = 'attributes', $message = null ) {
        $data = json_decode( json_encode($this->validSubmission) );

        $data->attributes->product_id = time();

        if(is_null($message)){
          $this->setExpectedExceptionRegExp(
              'OpenSRS\Exception',
              "/$field.*not defined/"
              );
        }
        else {
          $this->setExpectedExceptionRegExp(
              'OpenSRS\Exception',
              "/$message/"
              );
        }



        // clear field being tested
        if(is_null($parent)){
            unset( $data->$field );
        }
        else{
            unset( $data->$parent->$field );
        }

        $ns = new UpdateProduct( 'array', $data );
    }
}
