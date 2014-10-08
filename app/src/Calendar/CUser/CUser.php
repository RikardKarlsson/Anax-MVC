<?php
/**
 * Login and logout, forms and handling.
 * 
 * 
 * @author Rikard Karlsson
 * @version 14-04-15
 */
class CUser {
    private $loginHtmlOutput;
    private $logoutHtmlOutput;
    private $db;
    
    public function __construct($dataBase) {
        $this->loginHtmlOutput = "";
        $this->logoutHtmlOutput = "";
        $this->db = $dataBase; 
        
    }
    
    private function prepareLoginPage() {
        //TODO make menu appear when logged in
        // Check if user and password is okey
        //dump($_POST);
        $output = "";
        if ( isset($_GET['logout']) && $_GET['logout'] == 'logout') {
            $output .= "<p>Utloggningen lyckades.</p>";
        }
        if(isset($_POST['doLogin'])) {
          $sql = "SELECT acronym, name 
                FROM USER 
                WHERE acronym = ? AND password = md5(concat(?, salt))";
          $params = array(strip_tags($_POST['acronym']), strip_tags($_POST['password']));
          $res = $this->db->ExecuteSelectQueryAndFetchAll($sql, $params);
          //dump($res[0]);
          if(isset($res[0])) {
            $_SESSION['user'] = $res[0];
              
          }
          else {
              $output = "<p>Inloggningen MISSLYCKADES.</p>";
          }
          //header('Location: seed.php?p=login_success');
        }
        
        // Check if user is authenticated.
        $acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;
        $disabled="";
        $disabledInfo = ""; 
        if($acronym) {
            //header('Location: seed.php?p=login_success');
            header('Location: seed.php?p=logout&login=login');
            $output = "<p>Du är inloggad som: $acronym ({$_SESSION['user']->name})</p>";
            $output .=  "<em class='quiet small'>Du måste <a class='button' href='?p=logout'>logga ut</a> innan du kan logga in.</em>";
            
        }
        else {
          $output .= "
            <p>Du är INTE inloggad.</p>
            <p>
              <label for='input1'>Användarkonto:</label><br>
              <input id='input1' class='text' type='text' name='acronym'>
            </p>
            <p>
              <label for='input2'>Lösenord:</label><br>
              <input id='input2' class='text' type='password' name='password'>
            </p>
            <p>
              <input class='button' type='submit' name='doLogin' value='Login' >
            </p>";
        }
        $this->loginHtmlOutput = $output;
        
    }
    private function prepareLogoutPage()
    {
        //TODO make menu dispaper when logged out (uppdatera, skapa, radera)
        // Logout the user

        $output = "";
            if ( isset($_GET['login']) && $_GET['login'] == 'login' || 
                    isset($_SESSION['user'])) {
                $output .= "<p>Du är inloggad.</p>";
            }
            if(isset($_POST['doLogout'])) {
              unset($_SESSION['user']);
              header('Location: seed.php?p=login&logout=logout');
            }
            else {
                if ( isset($_SESSION['user']) ) {
                    $output .= "<p>
                      <input class='button' type='submit' name='doLogout' value='Logout' >
                    </p>";   
                }
                else {
                    $output .= "Du är redan utloggad.";
                }
            }
  
        $this->logoutHtmlOutput = $output;
    }
    public function getLoginFormHtml() {
        $this->prepareLoginPage();
        //page content
        $html = "<h1>Login</h1>";
        $html .= "<form class='form' method='post' action='?p=login'>
          <fieldset>
            <legend>Login</legend>
            $this->loginHtmlOutput
          </fieldset>
        </form>";
        return $html;
    }
    public function getLogoutFormHtml() {
        $this->prepareLogoutPage();
        $html = "<h1>Logout</h1>";
        $html .= "<form class='form' method='post' action='?p=logout'>
          <fieldset>
            <legend>Logout</legend>
            $this->logoutHtmlOutput
          </fieldset>
        </form>";
        return $html;
    }
}
