<?php
    //namespace Application;
    include 'config.php';
    class DatabaseConnectionObject{


        private $pdo;

        public function connect(){
            if($this->pdo == null){
                $this->pdo = new \PDO("sqlite:" . Config::PATH_TO_DATABASE);
            }
            return $this->pdo;
        }
        //add functions
        
        public function addUsers($username, $password, $name, $email){
            // Check if the username is unique
            if(!$this->isNewUsername($username)){
                return false;
            }
            //insert script
            $query = "INSERT INTO users(username, password, full_name, email_address) VALUES(:username, :password, :full_name, :email_address)";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([
                ':username' => $username,
                ':password' => $password,
                ':full_name' => $name,
                ':email_address' => $email,
            ]);
            return true;
        }
        public function addContractors($name, $password, $service){
            // Check if the username is unique
            if(!$this->isNewUsername($name)){
                return false;
            }
            $query = "INSERT INTO contractors(company_name, type_of_service, password, overall_stars) VALUES(:company_name, :type_of_service, :password, :overall_stars)";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([
                ':company_name' => $name,
                ':type_of_service' => $service,
                ':password' => $password,
                ':overall_stars' => 0,
            ]);
            return true;
        }
        public function addJob($jobTitle, $jobDesc, $cost, $userId){
            // Get the current time
            date_default_timezone_set("America/New_York"); 
            $date =  date("Y/m/d");
            // Get the username based on the user ID
            $query = "SELECT username FROM users WHERE user_id = $userId";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);
            $username = $row['username'];

            $query = "INSERT INTO jobs(user_id, poster, job_title, job_description, ticket_status, current_cost, leading_bidder, date) VALUES(:user_id, :poster, :job_title, :job_description, :ticket_status, :current_cost, :leading_bidder, :date)";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([
                ':user_id' => $userId,
                ':poster' => $username,
                ':job_title' => $jobTitle,
                ':job_description' => $jobDesc,
                ':ticket_status' => 'Bidding',
                ':current_cost' => $cost,
                ':leading_bidder' => 0,
                ':date' => $date,
            ]);
            return true;
        }




        public function addReviewers($reviewData){
            $query = "SELECT user_id FROM users WHERE username = :$reviewData[0]";
            $stmt = $this->pdo->prepare($query);
            $uid->$stmt->execute();
            $current_date = date("Y/m/d");
            
            //insert script
            $query = "INSERT INTO reviews(user_id, reviewer, date, contractor_name, star_rating, comments) VALUES(:user_id, :reviewer, :date, :contractor_name, :star_rating, :comments)";
            $stmt -> $this->pdo->prepare($query);
            $stmt->execute([
                ':user_id' => $uid,
                ':reviewer' => $reviewData[0],
                ':date' => $date,
                ':contractor_name' => $reviewData[1],
                ':star_rating' => $reviewData[2],
                ':comments' => $reviewData[3],
            ]);
        }

        public function addPaymentInformation($cardData){
            $query = "SELECT full_name FROM users WHERE username = :$cardData[0]";
            $stmt = $this->pdo->prepare($query);
            $uid->$stmt->execute();

            $query = "INSERT INTO paymentInfo(user_id, card_holder, card_number, month, year, csv) VALUES(:user_id, :card_holder, :card_number, :month, :year, :csv)";
            $stmt->$this->prepare($query);
            $stmt->execute([
                ':user_id' => $uid,
                ':card_holder' => $cardData[0],
                ':card_number' => $cardData[1],
                ':month' => $cardData[2],
                ':year' => $cardData[3],
                ':csv' => $cardData[4],
            ]);        
        }

        

        public function addBankInformation($bankData){
            $query = "SELECT contractor_id FROM contractors where company_name = :$bankData[0]";
            $stmt = $this->pdo->prepare($query);
            $uid->$stmt -> execute();

            $query = "INSERT INTO bank_info(contractor_id, routing_number, account_number) VALUES(:contractor_id, :routing_number, :account_number)";
            $stmt->this->pdo->prepare($query);
            $stmt->execute([
                ':contractor_id' => $bankData[1],
                ':routing_number' => $bankData[2],
                ':accounting_number' => $bankData[3],
            ]);
        }

        //remove functions

        //update functions

        public function updateUserInfo($updateData){
            $query = "SELECT user_id FROM users where username =: $updateData[0]"; //this username is the old one
            $stmt->this->pdo->prepare($query);
            $uid->stmt->execute();
            //Update
            $query = "UPDATE users SET username = :newUsername, password = :newPassword, full_name = :newFullName, email_address = :newEmailAddress WHERE user_id = :$uid";
            $stmt->this->pdo->prepare($query);
            $stmt->execute([
                ':newUsername' => $updateData[1],
                ':newPassword' => $updateData[2],
                ':newFullName' => $updateData[3],
                'newEmailAddress' => $updateData[4],
            ]);
        }

        /* Returns the id of the user if the username and password is correct */
        public function checkLogin($username, $password){
            $query = "SELECT user_id FROM users where username = '$username' AND password = '$password'"; //this username is the old one
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);
            if(isset($row) && isset($row['user_id'])){
                return $row['user_id'];
            }else{
                return false;
            }
        }
        /* Returns the id of the contractor if the username and password is correct */
        public function checkContractorLogin($username, $password){
            $query = "SELECT contractor_id FROM contractors where company_name = '$username' AND password = '$password'"; //this username is the old one
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();

            $row = $stmt->fetch(\PDO::FETCH_ASSOC);
            if(isset($row) && isset($row['contractor_id'])){
                return $row['contractor_id'];
            }else{
                return false;
            }
        }
        public function getServices(){
            $query = "SELECT service FROM typesOfService";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();

            $services = [];
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                array_push($services, $row['service']);
            }
            return $services;
        }
        public function addService($service){
            $query = "INSERT INTO typesOfService(service) VALUES('$service')";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
        }

        public function getCustomerJobs($userId, $viewAll){
            $where = "";
            if($viewAll!='true'){
                $where = "AND ticket_status='Open'";
            }
            $query = "SELECT poster, job_title, job_description, ticket_id, ticket_status, current_cost, company_name FROM (jobs JOIN contractors ON jobs.leading_bidder = contractors.contractor_id) WHERE user_id=$userId $where";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $jobs = [];
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $jobs[] = [
                    'poster' => $row['poster'],
                    'job_title' => $row['job_title'],
                    'job_description' => $row['job_description'],
                    'ticket_id' => $row['ticket_id'],
                    'ticket_status' => $row['ticket_status'],
                    'current_cost' => $row['current_cost'],
                    'company_name' => $row['company_name'],
                ];
            }
            return $jobs;
        }
        public function getContractorJobs($userId, $viewAll){
            $where = "";
            if($viewAll!='true'){
                $where = "AND ticket_status='Open'";
            }
            $query = "SELECT poster, job_title, job_description, ticket_id, ticket_status, current_cost, company_name FROM (jobs JOIN contractors ON jobs.leading_bidder = contractors.contractor_id) WHERE contractor_id=$userId $where";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $jobs = [];
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $jobs[] = [
                    'poster' => $row['poster'],
                    'job_title' => $row['job_title'],
                    'job_description' => $row['job_description'],
                    'ticket_id' => $row['ticket_id'],
                    'ticket_status' => $row['ticket_status'],
                    'current_cost' => $row['current_cost'],
                    'company_name' => $row['company_name'],
                ];
            }
            return $jobs;
        }

        //"Print" functions
            //Sends back information for the client side to print out.
        
        


        //helper functions
        public function createID(){
            $id="";
            for($x=0; $x<10; $x++){
                $digit = mt_rand(0,9);
                $id .= (string)$id;
            }
            return $id;
        }

        public function isNewUsername($str){
            $query = "SELECT username FROM users WHERE username='$str'";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);
            if(isset($row) && isset($row['username'])){
                return false;
            }
            $query = "SELECT company_name FROM contractors WHERE company_name='$str'";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);
            if(isset($row) && isset($row['company_name'])){
                return false;
            }
            return true;
        }
    }
?>