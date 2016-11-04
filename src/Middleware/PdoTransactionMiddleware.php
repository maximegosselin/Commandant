<?php
declare(strict_types = 1);
namespace MaximeGosselin\Commandant\Middleware;

use Exception;
use PDO;

class PdoTransactionMiddleware implements MiddlewareInterface
{
    /**
     * @var PDO
     */
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function __invoke($command, array $arguments, callable $next)
    {
        if ($this->pdo->inTransaction()) {
            $next($command, $arguments);
        } else {
            $this->pdo->beginTransaction();
            try {
                $next($command, $arguments);
                $this->pdo->commit();
            } catch (Exception $e) {
                $this->pdo->rollBack();
            }
        }
    }
}
