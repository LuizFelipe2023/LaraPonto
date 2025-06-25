<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProcessLoginRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Http\Requests\NewPasswordRequest;

class AuthController extends Controller
{
      protected AuthService $authService;

      public function __construct(AuthService $authService)
      {
            $this->authService = $authService;
      }

      public function showLoginForm()
      {
            return view('auth.login');
      }

      public function login(ProcessLoginRequest $request)
      {
            try {
                  $validatedData = $request->validated();
                  $this->authService->processLogin($validatedData);

                  return redirect()->route('home');
            } catch (ValidationException $e) {
                  return redirect()->back()
                        ->withErrors($e->errors())
                        ->withInput();
            } catch (Exception $e) {
                  Log::error('Erro ao autenticar o usuário', ['error' => $e->getMessage()]);

                  return redirect()->back()
                        ->with('error', 'Houve um erro ao autenticar o usuário. Por favor, verifique suas credenciais e tente novamente.')
                        ->withInput();
            }
      }

      public function logout(Request $request)
      {
            $this->authService->logout();
            return redirect()->route('login');
      }

      public function profile()
      {
             try{
                $user = $this->authService->getAuthenticatedUser();
                return view('profile.show',compact('user'));
             }catch(Exception $e){
                Log::error('Houve um erro ao recuperar o usuário autenticado',['error' => $e->getMessage()]);
                return redirect()->back()->with('error','Houve um erro ao retornar a pagina de perfil do usuário.');
             }
      }

      public function updatePassword(NewPasswordRequest $request)
      {
            try {
                  $validatedData = $request->validated();
                  $this->authService->updatePassword($validatedData);
                  return redirect()->back()->with('success', 'Senha alterada com sucesso!');
            }catch(Exception $e){
                  Log::error('Houve um erro inesperado ao atualizar a senha do usuario.',['error' => $e->getMessage()]);
                  return redirect()->back()->with('error','Houve um erro ao atualizar a senha, por favor verifique o formulário e tente novamente');
            }
      }
}
