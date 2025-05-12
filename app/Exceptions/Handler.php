/**
 * Handler.php
 * 
 * Ce fichier définit la classe Handler pour gérer les exceptions dans l'application Laravel.
 * 
 * @package App\Exceptions
 * @extends \Illuminate\Foundation\Exceptions\Handler
 */

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Liste des champs qui ne doivent jamais être stockés dans la session
     * lors d'une erreur de validation (ex : mots de passe).
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Enregistre les callbacks pour le reporting d'exceptions.
     *
     * @return void
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            // Personnaliser la logique de rapport d'erreurs ici si nécessaire
        });
    }

    /**
     * Convertit une exception en réponse HTTP.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Throwable $e)
    {
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => config('app.debug') ? $e->getTrace() : []
            ], 500);
        }

        return parent::render($request, $e);
    }
}
