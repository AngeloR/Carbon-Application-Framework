<?php

/**
 * Your application should always contain a DefaultController that extends the
 * primary Controller object. This example DefaultController will show you some
 * of the basic ways that this framework can be utilized. 
 *
 * @author xangelo
 */

class DefaultController extends Controller {

    public function home($args) {
        // Controller initiates whatever log_manager is specified
        // within the config file.
        //$this->log->logInfo('Logged!');

        // Load the models/views you want
        $this->LoadModel('Default');
        $this->LoadView('Default');
        //$this->Session->Clear();

        // Start adding content
        $tmp = new stdClass();
        $tmp->title = 'Viewing the home controller';
        $tmp->footer = 'Some random footer stuff';
        $tmp->content = 'Enter your name: ';
        $tmp->content .= l('Default/getcds',$this->DefaultModel->GetCDs());

        // Set up some sessions
        $tmp->content.= $this->Session->GetFromFlash('flashed').'<br>';
        if(!$this->Session->Has('appsig')) {
            $tmp->content .= 'Appsig set';
            $this->Session->Add('appsig','9n103rvn0vn0');
        }
        if(!$this->Session->Has('appver')) {
            $tmp->content .= 'Appver set';
            $this->Session->Add('appver','0.1');
        }

        // Create a form
        $MyForm = CarbonApp::LoadModule('FormManager',array('name','Default/getcds'));

        $MyForm->Input('f_name','text');
        $MyForm->CreateSubmitButton('Login and Save');
        $tmp->content .= $MyForm->Render();

        // Send data to the view
        $this->DefaultView->Homepage($tmp);
    }

    public function getcds($args) {
        $MyForm = CarbonApp::LoadModule('FormManager',array());
        $MyForm->GetFormValues();
        echo $this->Session->Get('appsig').'<br>'.$this->Session->Get('appver');
        $this->Session->Flash('flashed','soemtext should appear once');
        echo '<pre>'.print_r($this->Session,true).'</pre>';
        $this->LoadView('Default');
        $tmp->title = 'Viewing the home controller / getcds';
        $tmp->footer = 'Some random footer stuff';
        $tmp->content = 'Yep, got them cd\'s '.$MyForm->Values->f_name;
        $this->DefaultView->Homepage($tmp);
    }
}
?>
