<?php
class db
{   //database connection modify for every project
    protected static $host = 'localhost';
    protected static $username = 'root';
    protected static $password = 'misat0';
    protected static $database = 'imdb';
    protected static $pdo = null;
    //the global pdo project you want to make the connection once and reuse the connection. 


    public static function pdo()
    /**
    *this method should return the pdo object for 
    *the connection. If the connection has been 
    *made, it will just return the object, if not  
    *it will first connect and then return the 
    *object.
    *@return pdo connection
    */
    {   //remember that the name of the variable is static::$pdo
        if (static::$pdo === null)
        {
            // connect to the database
            try 
            {
                // store the connection (PDO) into static::$pdo
                static::$pdo = new PDO(
                // 'mysql:dbname=database_name;host=locahost;charset=utf8'
                'mysql:dbname='.static::$database.';host='.static::$host.';charset=utf8', 
                static::$username,
                static::$password
                );

                // set error reporting see most of the errors and we can debug correctly
                static::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } 
            catch (PDOException $e) 
            {
                // if something went wrong, just print out the error message            
                echo 'Connection failed: ' . $e->getMessage();
            }
        }
        //6.After the condition (ie. no matter if it runs or not), return the value of the static property $pdo
        return static::$pdo;

    }
    /** runs a SQL query and returns the statement
    *
    *@param $sql - SQL string
    *@param $substitutions - array of values to sustitute for ? 
    *@return PDOStatemnt object
    */


    public static function query($sql, $substitutions = [])
    {
        // get PDO connection object
        $pdo = static::pdo();
        
        // prepare a statement out of SQL
        $statement = $pdo->prepare($sql);
        
        // we run the query and keep the outcome (true or false)
        //we supply the substitutions for ?'s
        $outcome = $statement->execute($substitutions);

        // if there was an error
        if($outcome === false)
        {
            //print the error and exits we exit (we did this in the method exitWithError();)
            static::exitWithError();
        }


       // return the statement (pointing to the result)  
       return $statement;
    }
    /**7.
    *Within the class db copy the following method. It is a very simple method that will allow us to debug bad SQL queries:
    *an ugly (but better than nothing) way of output errors
    *
    */
    protected function exitWithError()
    {
        // print a <h1>
        echo '<h1>MySQL error:</h1>';
    
        // dump information about the error
        var_dump(static::pdo()->errorInfo());
    
        // end execution
        exit();
    }
}