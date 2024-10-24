

namespace App\Controllers\sinapptic;

use App\Controllers\BaseController;
use App\Models\sinapptic\usuarioModel;
use CodeIgniter\API\ResponseTrait as APIResponseTrait;
use Firebase\JWT\JWT;

class AuthController extends BaseController
{

    use APIResponseTrait; // Asegúrate de tener los traits importados adecuadamente

    protected $usuario;

    public function __construct()
    {
        $this->usuario = new usuarioModel();
    }
    public function login()
    {
        helper('secure_password_helpers');

        try {
            $json = $this->request->getJSON();
            $correoUsuario = $json->correo;
            $contraseña = $json->contraseña;
            $validarUsuario = $this->usuario->obtenerUsuarioPorCorreo($correoUsuario);
            $passwordHash = verifyPassword($contraseña, $validarUsuario['CONTRASEÑA']);
            if ($validarUsuario && $passwordHash) {
                $token = $this->setToken($validarUsuario);
                return $this->respond([
                    'message' => 'Usuario autenticado correctamente',
                    'token' => $token,
                    'data' => [
                        'Nombre' => $validarUsuario['NOMBRE'],
                        'Id' => $validarUsuario['ID'],
                        'Apellido' => $validarUsuario['APELLIDO'],
                        'Correo' => $validarUsuario['CORREO'],
                        'Img' => $validarUsuario['IMG_URL'],
                        'Descripcion' => $validarUsuario['ROL_DESCRIPCION'],
                    ]

                ], 200);
            } else {
                return $this->failUnauthorized('Credenciales inválidas');
            }
        } catch (\Exception $e) {
            return $this->failServerError('Ha ocurrido un error al intentar autenticar');
        }
    }
    function setToken($user)
    {
        $secretKey = getenv('JWT_SEGURA');
        $payload = [
            'iat' => time(),  
            'exp' => time() + 3600,  
            'sub' => base_url(),
            'data' => [
                'Nombre' => $user['NOMBRE'],
                'Id' => $user['ID'],

            ]
        ];
        $alg = 'HS256';
        $JWT = JWT::encode($payload, $secretKey, $alg);
        return $JWT;
    }

}
