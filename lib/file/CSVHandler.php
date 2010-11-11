<?php

	/////////////
	//CSVHandler class//
	/////////////

	/**
	 * Class for various csv related functions
	 *
	 * Contains functions for creation, output and parsing of csv files
	 *
	 * @package file
	 * @created 10/11/09
	 * @author Will McKenzie
	 */

class file_CSVHandler {

	//declare protected properties
	/**
	 * @var array contains all the data to be made turned into a csv file
	 */
	protected $data;

	/**
	 * @var array optional property containing all the headers for the csv file
	 */
	protected $headers;
	/**
	 * contains the created csv output
	 *
	 * @var string
	 */
	protected $csv_output = "";

	//declare class constants
	/**
	 * @var string defines new line character
	 */
	const END_OF_LINE = "\r\n";

	/**
	 * @var string defines escape character for special symbols
	 */
	const ESCAPED_BY = "\\\\\\";

	/**
	 * @var string defines field seperator character
	 */
	const TERMINATED_BY = ",";

	/**
	 * @var string defines field enclosure character
	 */
	const ENCLOSED_BY = '"';

	//declare constructor
	/**
	 * Constructor for CSVHandler object.
	 * @param object $data the data for the file
	 * @param object $headers [optional] headers for the file
	 * @return
	 */
	public function __construct($data,$headers=false){

		$this->data = $data;
		$this->headers = $headers;

	}

	/**
	 * Creates csv file
	 * @return
	 */
	private function _createCSV($filestream){

		if($this->headers)
			fputcsv($filestream,$this->headers,self::TERMINATED_BY,self::ENCLOSED_BY);

		foreach($this->data as $row)
			fputcsv($filestream,$this->_formatData(((!is_array($row)) ? array($row) : $row)),self::TERMINATED_BY,self::ENCLOSED_BY);;

	}

	public function download($filename){
		header("Content-type: text/csv");
		header("Cache-Control: no-store, no-cache");
		header('Content-Disposition: attachment; filename="' . $filename . '.csv"');
		$output = fopen("php://output",'w');
		$this->_createCSV($output);
		fclose($output);
	}

	public function save($filename){
		$fhandle = fopen($filename. '.csv','w') or die("can't open file");
		$this->_createCSV($fhandle);
		fclose($fhandle);
	}

	/**
	 * Takes in array of fields to be sanitised and returns the sanitised array
	 *
	 * @param array $fields data to be sanitised
	 * @return array sanitised data
	 */
	private function _formatData(array $fields){
		foreach($fields as &$field){
			$field = preg_replace('/[\r\n]/','',$field);
		}
		return $fields;
	}
}
?>