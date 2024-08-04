<?php

namespace App\Traits;

trait HttpResponse
{
    public function success(string $message)
    {
        // Apenas um exemplo de trait para organização
        // Seria bem mais robusto para casos com reponse json
        return redirect()->back()->with('success', $message);
    }

    public function error(string $message)
    {
        return redirect()->back()->with('error', $message);
    }
}
