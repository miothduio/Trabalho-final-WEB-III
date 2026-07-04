/*
|--------------------------------------------------------------------------
| Ativação e status do Totem
|--------------------------------------------------------------------------
|
| A chave gerada pelo administrador (tela Totens do cozinha_restaurante)
| só pode ativar UM totem: ela é digitada aqui uma única vez e, se ainda
| não tiver sido usada, o servidor troca ela por um token secreto — é
| esse token (não a chave) que fica salvo no localStorage e é usado em
| todas as chamadas seguintes (identificar/heartbeat). Se alguém tentar
| usar a mesma chave em outro navegador depois disso, a ativação falha.
|
*/

function totemToken() {
    return localStorage.getItem('totem_token');
}

function salvarToken(token) {
    localStorage.setItem('totem_token', token);
}

function limparIdentidade() {
    localStorage.removeItem('totem_token');
    localStorage.removeItem('totem_dados');
}

function totemDados() {
    return JSON.parse(localStorage.getItem('totem_dados')) || {};
}

function salvarTotemDados(dados) {
    localStorage.setItem('totem_dados', JSON.stringify(dados));
    atualizarBadgeNumero();
}

function atualizarBadgeNumero() {
    const el = document.getElementById('totemNumero');
    if (!el) return;

    const dados = totemDados();

    el.innerText = dados.numero_totem
        ? 'Totem ' + String(dados.numero_totem).padStart(2, '0')
        : 'Totem --';
}

function atualizarBadgeStatus(online) {
    const status = document.getElementById('statusServidor');
    if (!status) return;

    status.innerHTML = online
        ? '<span class="status-online"><i class="bi bi-circle-fill"></i> Servidor Online</span>'
        : '<span class="status-offline"><i class="bi bi-circle-fill"></i> Servidor Offline</span>';
}

function mostrarAtivacao(mensagemErro) {
    const overlay = document.getElementById('overlayAtivacao');
    if (!overlay) return;

    overlay.style.display = 'flex';

    const erro = document.getElementById('erroChaveAtivacao');
    if (mensagemErro) {
        erro.innerText = mensagemErro;
        erro.style.display = 'block';
    } else {
        erro.style.display = 'none';
    }
}

function esconderAtivacao() {
    const overlay = document.getElementById('overlayAtivacao');
    if (overlay) overlay.style.display = 'none';
}

/*
|--------------------------------------------------------------------------
| Ativa o totem consumindo a chave. Só funciona se ela ainda não tiver
| sido usada em outro totem.
|--------------------------------------------------------------------------
*/

async function ativarTotemComChave() {
    const input = document.getElementById('inputChaveAtivacao');
    const btn = document.getElementById('btnAtivarTotem');
    const chave = input.value.trim();

    if (!chave) {
        input.focus();
        return;
    }

    btn.disabled = true;
    btn.innerText = 'Ativando...';

    try {
        const resposta = await fetch(API_BASE + '/totem/ativar', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'chave=' + encodeURIComponent(chave)
        });

        const json = await resposta.json();

        if (json.status) {
            salvarToken(json.token);
            salvarTotemDados(json.totem);
            esconderAtivacao();
            heartbeat();
        } else {
            mostrarAtivacao(json.mensagem || 'Não foi possível ativar. Tente novamente.');
        }
    } catch (e) {
        mostrarAtivacao('Erro de comunicação com o servidor.');
        console.error('Erro ao ativar totem:', e);
    } finally {
        btn.disabled = false;
        btn.innerText = 'Ativar Totem';
    }
}

/*
|--------------------------------------------------------------------------
| Identifica o totem pelo token já salvo neste navegador. Se ainda não
| tem token, tenta ativar automaticamente com uma chave vinda da URL
| (?chave=A1B2C3), útil para configurar o totem físico de uma vez só.
|--------------------------------------------------------------------------
*/

async function identificarTotem() {
    const token = totemToken();

    if (!token) {
        const chaveUrl = new URLSearchParams(window.location.search).get('chave');

        if (chaveUrl) {
            document.getElementById('inputChaveAtivacao').value = chaveUrl;
            await ativarTotemComChave();
            return;
        }

        mostrarAtivacao(null);
        return;
    }

    try {
        const resposta = await fetch(
            API_BASE + '/totem/identificar?token=' + encodeURIComponent(token)
        );

        const json = await resposta.json();

        if (json.status) {
            salvarTotemDados(json.totem);
            esconderAtivacao();
        } else {
            limparIdentidade();
            mostrarAtivacao('Este totem precisa ser ativado novamente.');
        }
    } catch (e) {
        console.error('Erro ao identificar totem:', e);
    }
}

async function heartbeat() {
    const token = totemToken();

    // Ainda não ativado: nada para reportar
    if (!token) return;

    try {
        const resposta = await fetch(API_BASE + '/totem/heartbeat', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'token=' + encodeURIComponent(token)
        });

        const json = await resposta.json();

        atualizarBadgeStatus(!!json.status);
    } catch (e) {
        atualizarBadgeStatus(false);
    }
}

document.addEventListener('DOMContentLoaded', async function () {
    atualizarBadgeNumero();

    const input = document.getElementById('inputChaveAtivacao');
    if (input) {
        input.addEventListener('keyup', function (evento) {
            if (evento.key === 'Enter') ativarTotemComChave();
        });
    }

    await identificarTotem();

    heartbeat();
    setInterval(heartbeat, 30000);
});
