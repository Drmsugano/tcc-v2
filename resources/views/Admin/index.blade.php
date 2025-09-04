@extends('layout')
@section('conteudo')
    <div class="container mt-5">
        <h2 class="mb-4 fw-bold text-secondary">⚙️ Área Administrativa do Sistema</h2>

        <div class="d-flex gap-4 flex-wrap">
            <!-- Botão de Listagem -->
            <a href="#"
                class="btn btn-gradient-primary btn-lg d-flex align-items-center justify-content-center shadow-sm custom-btn">
                <i class='bx bx-list-ul me-2'></i>
                Listagem
            </a>

            <!-- Botão de Cadastro -->
            <a href="#"
                class="btn btn-gradient-success btn-lg d-flex align-items-center justify-content-center shadow-sm custom-btn">
                <i class='bx bx-plus-circle me-2'></i>
                Cadastro
            </a>
        </div>
    </div>

    <style>
        /* Gradientes modernos para os botões */
        .btn-gradient-primary {
            background: linear-gradient(135deg, #4e73df, #224abe);
            color: #fff;
            transition: all 0.3s ease;
        }
        .btn-gradient-primary:hover {
            background: linear-gradient(135deg, #224abe, #4e73df);
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }
        .btn-gradient-success {
            background: linear-gradient(135deg, #1cc88a, #17a673);
            color: #fff;
            transition: all 0.3s ease;
        }
        .btn-gradient-success:hover {
            background: linear-gradient(135deg, #17a673, #1cc88a);
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }
        /* Padding extra e cantos arredondados */
        .custom-btn {
            border-radius: 0.75rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            font-size: 1.1rem;
        }

        /* Pequena animação de ícone no hover */
        .custom-btn i {
            transition: transform 0.3s ease;
        }

        .custom-btn:hover i {
            transform: rotate(15deg);
        }
    </style>
@endsection