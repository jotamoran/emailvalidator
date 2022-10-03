<?php

    class emailvalidator
    {    
        public static function check($email)
        {
            //get the email to check up, clean it
            $email = filter_var($email,FILTER_SANITIZE_STRING);

            // 1 - check valid email format using RFC 822
            if (filter_var($email, FILTER_VALIDATE_EMAIL)===FALSE) 
                return 'No valid email format';
                
            //get email domain to work in nexts checks
            $email_domain = preg_replace('/^[^@]++@/', '', $email);

            // 2 - check if its from banned domains.
            if (in_array($email_domain,self::get_banned_domains()))
                return 'Banned domain '.$email_domain;
                
            // 3 - check DNS for MX records
            if ((bool) checkdnsrr($email_domain, 'MX')==FALSE)
                return 'DNS MX not found for domain '.$email_domain;

            // 4 - wow actually a real email! congrats ;)
            return TRUE;
        }

        
        private static function get_banned_domains()
        {
            
            $file = 'banned_domains.json';
            
            if (!file_exists($file) OR (file_exists($file) AND filemtime($file) < strtotime('-1 week')) )
            {
                $banned_domains = file_get_contents("banned_domains.json");
                if ($banned_domains !== FALSE)
                    file_put_contents($file,$banned_domains,LOCK_EX);
            }
            else
                $banned_domains = file_get_contents($file);

            return json_decode($banned_domains);
        }
    }
?>