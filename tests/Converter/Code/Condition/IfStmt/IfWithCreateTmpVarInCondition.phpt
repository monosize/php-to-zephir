--TEST--
Test continue stmt
--DESCRIPTION--
Lowlevel basic test
--FILE--
<?php

require __DIR__ . '/../../../../Bootstrap.php';

use PhpToZephir\EngineFactory;
use PhpToZephir\Logger;
use Symfony\Component\Console\Output\NullOutput;
use PhpToZephir\Render\StringRender;
use PhpToZephir\CodeCollector\StringCodeCollector;

$engine = EngineFactory::getInstance(new Logger(new NullOutput(), false));
$code   = <<<'EOT'
<?php

namespace Code\Condition\IfStmt;

class IfWithCreateTmpVarInCondition
{
    public function test($toto)
    {
        if (array() == $toto) {
            echo 'tata';
        }

        if ("im a string" == $toto) {
            echo 'tata';
        }

        if (false == $toto) {
            echo 'tata';
        }

        if ($toto === true && $toto === array(10)) {
            echo 'tata';
        }

        if ($toto === true && $toto === array() || $toto === false) {
            echo 'tata';
        }

        if ($toto === true && $toto === array() || $toto === false && $toto === true) {
            echo 'tata';
        }
    }
}
EOT;
$render = new StringRender();
$codeValidator = new PhpToZephir\CodeValidator();

foreach ($engine->convert(new StringCodeCollector(array($code))) as $file) {
	$zephir = $render->render($file);
	$codeValidator->isValid($zephir);
	
	echo $zephir;
}

?>
--EXPECT--
namespace Code\Condition\IfStmt;

class IfWithCreateTmpVarInCondition
{
    public function test(toto) -> void
    {
        var tmpArray40cd750bba9870f18aada2478b24840a, tmpArray6ef611fccd6ae1abb1ff53cf46464309;
    
        let tmpArray40cd750bba9870f18aada2478b24840a = [];
        if toto == tmpArray40cd750bba9870f18aada2478b24840a {
            echo "tata";
        }
        
        if toto == "im a string" {
            echo "tata";
        }
        
        if toto == false {
            echo "tata";
        }
        let tmpArray6ef611fccd6ae1abb1ff53cf46464309 = [10];
        if toto === true && toto === tmpArray6ef611fccd6ae1abb1ff53cf46464309 {
            echo "tata";
        }
        let tmpArray40cd750bba9870f18aada2478b24840a = [];
        if toto === true && toto === tmpArray40cd750bba9870f18aada2478b24840a || toto === false {
            echo "tata";
        }
        let tmpArray40cd750bba9870f18aada2478b24840a = [];
        if toto === true && toto === tmpArray40cd750bba9870f18aada2478b24840a || toto === false && toto === true {
            echo "tata";
        }
    }

}