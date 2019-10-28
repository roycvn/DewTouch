<?php

class FileUploadController extends AppController {
	public function index() {
		$this->set('title', __('File Upload Answer'));

		if ($this->request->is('post')) {
			if(isset($this->request->data['FileUpload']['file']['name'])) {
				$uploadingPath =  $this->request->data['FileUpload']['file']['name'];
				move_uploaded_file($this->request->data['FileUpload']['file']['tmp_name'], $uploadingPath);
				$this->readCSVData($uploadingPath);
			}
		}
		$file_uploads = $this->FileUpload->find('all');
		$this->set(compact('file_uploads'));
	}

	public function readCSVData($filename) {
		$handle = fopen($filename, "r");
		$rowId = 2;
		$columnCounter = 1;
		$row = 1;
		
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			$num = count($data);
			$row++;
			if($row == 2) {continue;}
			$populatedData['name'] = $data[0];
			$populatedData['email'] = $data[1];
			$this->FileUpload->saveAll($populatedData);
		}
		fclose($handle);
	}
}