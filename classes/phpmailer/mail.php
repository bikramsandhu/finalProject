<?php
include('phpmailer.php');
class Mail extends PhpMailer
{
    // set default values for all variables
    public $From     = 'noreply@domain.com';
    public $FromName = SITETITLE;

    public function subject($subject)
    {
        $this->Subject = $subject;
    }

    public function body($body)
    {
        $this->Body = $body;
    }

    public function send()
    {
        $this->AltBody = strip_tags(stripslashes($this->Body))."\n\n";
        $this->AltBody = str_replace("&nbsp;", "\n\n", $this->AltBody);
        return parent::send();
    }
}
