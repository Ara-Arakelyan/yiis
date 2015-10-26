<?php

class SiteController extends Controller {

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
//        if (isset($_POST["val"])) {
//            $post = $_POST['val'];
//            $mod = Stringlist::model()->findAll();
//            echo CJSON::encode($mod);
//            Yii::app()->end();
//        }

        $model = Categories::model()->sel();
        $mod = Stringlist::model()->findAll();
        $this->render('index', array('model' => $model, 'mod' => $mod));
    }

    /*
     * create action
     */

    public function actionUrl($id) {
       // $url ="$_SERVER[REQUEST_URI]" ;
       
       
        $firstBracket = '{';
        $secondBracket = '[';
        $thirdBracket = '(';
        $string =  $id;
        $string = trim($string);
        $characters = str_split($string);
        if (count($characters) % 2 != 0) {
            die("invalid");
        }

        for ($i = 0; $i <= count($characters) / 2; $i++) {
            
            switch ($characters[$i]) {
                case $firstBracket:
                    if ($characters[count($characters) - 1 - $i] == '}') {
                        continue;
                    } else {
                        die('invalid');
                    }
                    break;
                case $secondBracket:
                    if ($characters[count($characters) - 1 - $i] == ']') {
                        continue;
                    } else {
                        die('invalid');
                    }
                    break;
                case $thirdBracket:
                    if ($characters[count($characters) - 1 - $i] == ')') {
                        continue;
                    } else {
                        die('invalid');
                    }
                    break;
            } die('valid');
        }
        $this->render("url");
    }

    public function actionFile() {
        if (isset($_POST["submit"])) {

            if (isset($_FILES["file"])) {
                $ext = strtolower(end(explode('.', $_FILES['file']['name'])));
                $tmpName = $_FILES['file']['tmp_name'];
                $max_filesize = 50000;
                if (filesize($_FILES['file']['tmp_name']) > $max_filesize)
                    die('The file you attempted to upload is larger ');
                //if there was an error uploading the file
                if ($_FILES["file"]["error"] > 0) {
                    echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
                } else {
                    //Print file details
                    //if file already exists
                    $f = array();
                    if (file_exists("csv/" . $_FILES["file"]["name"])) {
                        echo $_FILES["file"]["name"] . " already exists. ";
                    } else {
                        if ($ext === 'csv') {
                            $csv = array();
                            if (($handle = fopen($tmpName, 'r')) !== FALSE) {
                                // necessary if a large csv file
                                set_time_limit(0);

                                $row = 0;

                                while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                                    // number of fields in the csv
                                    $col_count = count($data);

                                    // get the values from the csv
                                    $csv[$row]['col1'] = $data[0];
                                    $csv[$row]['col2'] = $data[1];
                                    $csv[$row]['col3'] = $data[3];
                                    $csv[$row]['col4'] = $data[4];

                                    // inc the row
                                    $row++;
                                }
                                fclose($handle);
                            }

                            function array_filter_null_recursive($csv) {
                                //Filter the elements with a custom callback function, passing value as reference.
                                return array_filter($csv, function( &$value ) {
                                    //If this element is an array, recursivly filter and modify the array.
                                    if (is_array($value)) {
                                        $value = array_filter_null_recursive($value);
                                        return true;
                                    }
                                    //Otherwise, check if null.
                                    return !is_null($value);
                                });
                            }

                            $i = 0;
                            $new = array();

                            foreach (array_filter_null_recursive($csv) as $key => $value) {


                                $new[] = $value;

                                foreach ($new as $k) {
                                    if ($k["col2"] != $value["col2"]) {
                                        $f[] = $value;
                                        $key + 1;
                                    }
                                }
                            };
                        };




                        //Store file in directory "upload" with the name of "uploaded_file.txt"

                        $contents = '';
                        foreach (array_unique($f, SORT_REGULAR) as $line => $bool)
                            $contents .= $bool["col1"] . "," . $bool["col2"] . "," . $bool["col3"] . "," . $bool["col4"] . "\r\n";

// save it to a new file
                        file_put_contents("csv/test_unique.csv", $contents);
                        $this->render('file');
                    }
                }
            } else {
                echo "No file selected <br />";
            }
        }
        $this->render('file');
// build the new content-data
    }

    /*
     * 
     * add action 
     */

    public function actionAdd() {

        if (isset($_POST['name']) && $_POST['name'] == 'q') {
            $d = Categories::model()->sel();
            echo $d;
            die();
        }
        if (isset($_POST['Submit'])) {
            $file_name = $_FILES['audio_file']['name'];


            $model = Categories::model()->inserts($file_name);
            $d = Categories::model()->sel();
            if ($_FILES['audio_file']['type'] == 'audio/mpeg' || $_FILES['audio_file']['type'] == 'audio/mpeg3' || $_FILES['audio_file']['type'] == 'audio/x-mpeg3' || $_FILES['audio_file']['type'] == 'audio/mp3' || $_FILES['audio_file']['type'] == 'audio/x-wav' || $_FILES['audio_file']['type'] == 'audio/wav') {
                $new_file_name = $_FILES['audio_file']['name'];

                // Where the file is going to be placed
                $target_path = "mp3/" . $new_file_name;

                //target path where u want to store file.
                //following function will move uploaded file to audios folder. 
                if (move_uploaded_file($_FILES['audio_file']['tmp_name'], $target_path)) {
                    if ($model == 1) {
                        echo $file_name;
                    } else {

                        echo $d;
                        die();
                    }

                    //insert query if u want to insert file
                }
            }
        }
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact() {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" .
                        "Reply-To: {$model->email}\r\n" .
                        "MIME-Version: 1.0\r\n" .
                        "Content-Type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Displays the login page
     */
    public function actionLogin() {
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

}
