<?php
class BloomFilter {
    private $size;
    private $bitArray;
    private $hashCount;

    public function __construct($size, $hashCount) {
        $this->size = $size;
        $this->bitArray = array_fill(0, $size, 0);
        $this->hashCount = $hashCount;
    }

    //使用7個hash function
    private function hash($item, $i) {
        return (crc32($item) + $i * ord($item[0])) % $this->size;
    }

    //將弱密碼加入bit array
    public function add($item) {
        for ($i = 0; $i < $this->hashCount; $i++) {
            $this->bitArray[$this->hash($item, $i)] = 1;
        }
    }

    public function mightContain($item) {
        for ($i = 0; $i < $this->hashCount; $i++) {
            if ($this->bitArray[$this->hash($item, $i)] == 0) {
                return false;
            }
        }
        return true;
    }
}

//假設100個 key ，希望false-positive 1%
// 初始化 Bloom Filter，設置 7 個 hash function和 1000 bit array
$hashCount = 7;
$bitArraySize = 1000;
$bloomFilter = new BloomFilter($bitArraySize, $hashCount);

// 加入弱密碼列表
$weakPasswords = ['123456', 'password', 'qwerty', 'abc123', '111111', 'letmein', '123123'];
foreach ($weakPasswords as $weakPassword) {
    $bloomFilter->add($weakPassword);
}

// 即時檢查密碼是否為弱密碼
if (isset($_POST['password'])) {
    $password = $_POST['password'];

    if ($bloomFilter->mightContain($password)) {
        echo 'weak';
    } else {
        echo 'strong';
    }
}
?>
