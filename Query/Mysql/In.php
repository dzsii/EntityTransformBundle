<?php

namespace ThinkBig\Bundle\EntityTransformBundle\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * InFunction ::=
 *     "IN_MULTI" "(" ArithmeticPrimary ", INTERVAL" ArithmeticPrimary Identifier ")"
 */
class In extends FunctionNode
{
    public $haystack    = null;
    public $needle      = null;

    public function parse(Parser $parser)
    {
        
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->needle = $parser->StateFieldPathExpression();

        // first Path Expression is mandatory
        $this->haystack  = array();
        
        $lexer = $parser->getLexer();
        
        while ($lexer->isNextToken(Lexer::T_COMMA)) {
            $parser->match(Lexer::T_COMMA);
            $this->haystack[] = $parser->StateFieldPathExpression();
        }

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);

    }

    public function getSql(SqlWalker $sqlWalker)
    {

        $fields = array();

        foreach ($this->hastack as $pathExp) {
            $fields[] = $pathExp->dispatch($sqlWalker);
        }
        
        return sprintf('(%s) IN (%s)', implode(', ', $fields), $this->needle->dispatch($sqlWalker));

    }
}