<?php

class Validator{

    /**
     * @var array $data - Data to validate.
     */
    private $data;

    /**
     * @var string $current_field - Current selected key/field to validae data.
     */
    private $current_field;

    /**
     * @var string $current_alias - Alias use on error messages instead of field name.
     */
    private $current_alias;

    /**
     * @var array $response_messages - Error messages to show user.
     * 
     * You can change messages from here. User "{field}" to refer the field name.
     */
    private $response_messages = [
        "required" => "{field} is required.",
        "alpha" => "{field} must contains alphabatic charectors only.",
        "alpha_num" => "{field} must contains alphabatic charectors & numbers only.",
        "numeric" => "{field} must contains numbers only.",
        "email" => "{field} is invalid.",
        "max_len" => "{field} is too long.",
        "min_len" => "{field} is too short.",
        "max_val" => "{field} is too high.",
        "min_val" => "{field} is too low.",
        "enum" => "{field} is invalid.",
        "equals" => "{field} does not match.",
        "must_contain" => "{field} must contains {chars}.",
        "match" => "{field} is invalid.",
        "date" => "{field} is invalid.",
        "date_after" => "{field} date is not valid.",
        "date_before" => "{field} date is not valid.",
    ];

    /**
     * @var array $error_messages - Error message generated after validation of each field.
     */
    public $error_messages = [];

    /**
     * @var boolean $next - Check if next validation on the field shoud run or not.
     */
    private $next = true;

    /**
     * Validator - Create new instance of Validator class.
     * 
     * @param array $data - Data to validate.
     * @return object Validator
     */
    function __construct($data){
        $this->data = $data;
    }

    /**
     * add_error_message - Create and add error message after each validation faild.
     * 
     * @param string $type - Key of $response_messages array.
     * @return void
     */
    private function add_error_message($type, $others = []){
        $field_name = $this->current_alias ? ucfirst($this->current_alias) : ucfirst($this->current_field);
        $msg = str_replace('{field}', $field_name, $this->response_messages[$type]);
        foreach($others as $key => $val){
            $msg = str_replace('{'.$key.'}', $val, $msg);
        }
        $this->error_messages[$this->current_field] = $msg;
    }
    
    /**
     * exists - Check if the current field or field value exists or not.
     * 
     * @return boolean
     */
    private function exists(){
        if(!isset($this->data[$this->current_field]) || !$this->data[$this->current_field]){
            return false;
        }
        return true;
    }

    /**
     * set_response_messages - Function to set/extend custom error response messages.
     * 
     * @param array $mesages
     * @return void
     */
    function set_response_messages($messages){
        foreach($messages as $key => $val){
            $this->response_messages[$key] = $val;
        }
    }

    /**
     * field - Set the field name to start validation.
     * 
     * @param string $name - Name of the field/key as on data to validate.
     * @param string $alias - (optional) Alias use on error messages instead of field name.
     * @return this
     */
    function field($name, $alias = null){
        $this->current_field = $name;
        $this->next = true;
        $this->current_alias = $alias;
        return $this;
    }
    
    /**
     * required - Check if the value exists.
     * 
     * @return this
     */
    function required(){
        if(!$this->exists()){
            $this->add_error_message('required');
            $this->next = false;
        }
        return $this;
    }

    /**
     * alpha - Check if the value is alpha only.
     * 
     * @param array $ignore - (Optional) add charectors to allow.
     * @return this
     */
    function alpha($ignore = []){
        if($this->next && $this->exists() && !ctype_alpha(str_replace($ignore, '', $this->data[$this->current_field]))){
            $this->add_error_message('alpha');
            $this->next = false;
        }
        return $this;
    }

    /**
     * alpha_num - Check if the value is alpha numeric only.
     * 
     * @param array $ignore - (Optional) add charectors to allow.
     * @return this
     */
    function alpha_num($ignore = []){
        if($this->next && $this->exists() && !ctype_alnum(str_replace($ignore, '', $this->data[$this->current_field]))){
            $this->add_error_message('alpha_num');
            $this->next = false;
        }
        return $this;
    }

    /**
     * numeric - Check if the value is numeric only.
     * 
     * @return this
     */
    function numeric(){
        if($this->next && $this->exists() && !is_numeric($this->data[$this->current_field])){
            $this->add_error_message('numeric');
            $this->next = false;
        }
        return $this;
    }

    /**
     * email - Check if the value is a valid email.
     * 
     * @return this
     */
    function email(){
        if($this->next && $this->exists() && !filter_var($this->data[$this->current_field], FILTER_VALIDATE_EMAIL)){
            $this->add_error_message('email');
            $this->next = false;
        }
        return $this;
    }

    /**
     * max_len - Check if length of the value is larger than the limit.
     * 
     * @param int $size - Max length of charectors of the value.
     * @return this
     */
    function max_len($size){
        if($this->next && $this->exists() && strlen($this->data[$this->current_field]) > $size){
            $this->add_error_message('max_len');
            $this->next = false;
        }
        return $this;
    }

     /**
     * min_len - Check if length of the value is smaller than the limit.
     * 
     * @param int $size - Min length of charectors of the value.
     * @return this
     */
    function min_len($size){
        if($this->next && $this->exists() && strlen($this->data[$this->current_field]) < $size){
            $this->add_error_message('min_len');
            $this->next = false;
        }
        return $this;
    }

    /**
     * max_val - Check if the value of intiger/number is not larger than limit.
     * 
     * @param int $val - Max value of the number.
     * @return this
     */
    function max_val($val){
        if($this->next && $this->exists() && $this->data[$this->current_field] > $val){
            $this->add_error_message('max_val');
            $this->next = false;
        }
        return $this;
    }

    /**
     * min_val - Check if the value of intiger/number is not smaller than limit.
     * 
     * @param int $val - Min value of the number.
     * @return this
     */
    function min_val($val){
        if($this->next && $this->exists() && $this->data[$this->current_field] < $val){
            $this->add_error_message('min_val');
            $this->next = false;
        }
        return $this;
    }

    /**
     * enum - Check if the value is in the list.
     * 
     * @param array $list - List of valid values.
     * @return this
     */
    function enum($list){
        if($this->next && $this->exists() && !in_array($this->data[$this->current_field], $list)){
            $this->add_error_message('enum');
            $this->next = false;
        }
        return $this;
    }

    /**
     * equals - Check if the value is equal.
     * 
     * @param mixed $value - Value to match equal.
     * @return this
     */
    function equals($value){
        if($this->next && $this->exists() && $this->data[$this->current_field] != $value){
            $this->add_error_message('equals');
            $this->next = false;
        }
        return $this;
    }

    /**
     * date - Check if the value is a valid date.
     * 
     * @param mixed $format - format of the date. (ex. Y-m-d) Check out https://www.php.net/manual/en/datetime.format.php for more.
     * @return this
     */
    function date($format = 'Y-m-d'){
        if($this->next && $this->exists()){
            $dateTime = DateTime::createFromFormat($format, $this->data[$this->current_field]);
            if(!($dateTime && $dateTime->format($format) == $this->data[$this->current_field])){
                $this->add_error_message('date');
                $this->next = false;
            }
        }
        return $this;
    }

    /**
     * date_after - Check if the date appeared after the specified date.
     * 
     * @param mixed $date - Use format Y-m-d (ex. 2023-01-15).
     * @return this
     */
    function date_after($date){
        if($this->next && $this->exists() && strtotime($date) >= strtotime($this->data[$this->current_field])){
            $this->add_error_message('date_after');
            $this->next = false;
        }
        return $this;
    }

    /**
     * date_before - Check if the date appeared before the specified date.
     * 
     * @param mixed $date - Use format Y-m-d (ex. 2023-01-15).
     * @return this
     */
    function date_before($date){
        if($this->next && $this->exists() && strtotime($date) <= strtotime($this->data[$this->current_field])){
            $this->add_error_message('date_before');
            $this->next = false;
        }
        return $this;
    }

    /**
     * must_contain - Check if the value must contains some charectors.
     * 
     * @param string $chars - Set of chars in one string ex. "@#$&abc123".
     * @return this
     */
    function must_contain($chars){
        if($this->next && $this->exists() && !preg_match("/[".$chars."]/i", $this->data[$this->current_field])){
            $this->add_error_message('must_contain', ['chars' => $chars]);
            $this->next = false;
        }
        return $this;
    }

    /**
     * match - Check if the value matchs a pattern.
     * 
     * @param string $patarn - Rejex pattern to match.
     * @return this
     */
    function match($patarn){
        if($this->next && $this->exists() && !preg_match($patarn, $this->data[$this->current_field])){
            $this->add_error_message('match');
            $this->next = false;
        }
        return $this;
    }

    /**
     * is_valid - Check if all validations is successfull.
     * 
     * @return boolean
     */
    function is_valid(){
        return count($this->error_messages) == 0;
    }

    function get_error_message($field){
        if(isset($this->error_messages[$field])){
            return $this->error_messages[$field];
        }
        return "";
    }

    
}

 

 

 

 

 

require_once("Utils/Validator.php");

 

$id = $_GET['id'];
$dbContext = new Database();
// Hämta den produkt med detta ID
$product = $dbContext->getProduct($id); // TODO felhantering om inget produkt
$v = new Validator($_POST);

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    // Här kommer vi när man har tryckt  på SUBMIT
    // IMORGON TISDAG SÅ UPDATE PRODUCT SET title = $_POST['title'] WHERE id = $id
    $product->title = $_POST['title'];
    $product->stockLevel = $_POST['stockLevel'];

    $product->price = $_POST['price'];
    $product->categoryName = $_POST['categoryName'];
    $product->popularityFactor = $_POST['popularityFactor'];

    // validera
    $v->field('title')->required()->alpha_num([' '])->min_len(3)->max_len(50);
    $v->field('stockLevel')->required()->numeric()->min_val(0);
    $v->field('price')->required()->numeric()->min_val(0);
    //$v->field('price')->equals($_POST['stockLevel'])->required()->numeric()->min_val(0)->max_val(10000);
    //$v->field('categoryName')->required()->alpha_num([' '])->min_len(3)->max_len(50);
    $v->field('categoryName')->equals($_POST['title']);
    $v->field('popularityFactor')->required()->numeric()->min_val(0);

    // om ok så spara i databas
    if($v->is_valid()){
        // OK - spara i databas
         $dbContext->updateProduct($product);
        header("Location: /admin/products");
        exit;
    }
}else{
    // Det är INTE ett formulär som har postats - utan man har klickat in på länk tex edit.php?id=12
}
?>

<form method="POST" > 
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control <?php echo $v->get_error_message('title') != "" ? "is-invalid" : ""  ?>" name="title" value="<?php echo $product->title ?>">
            <span class="invalid-feedback"><?php echo $v->get_error_message('title');  ?></span>                        
        </div>
    
    </form>