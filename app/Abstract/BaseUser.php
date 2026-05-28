<?php
namespace App\Abstract;

use Illuminate\Database\Eloquent\Model;

abstract class BaseUser extends Model {
    protected $fillable = [
        'nama', 'email', 'password', 'role'
    ];
    protected $hidden = ['password'];

    abstract public function login(string $email, string $password);
    abstract public function getDashboard();

    public function logout() {
        auth()->logout();
        return redirect('/login')->with('succes', $this->nama . 'berhasil logout');
    }
    public function getProfile(){
        return [
            'id' => $this->id,
            'nama' => $this->nama,
            'email' => $this->email,
            'role' => $this->role
        ];
    }
    public function ubahPassword(string $passwordBaru) {
        $this->password = bcrypt($passwordBaru);
        $this->save();
        return 'Password berhasil diubah';
    }
}