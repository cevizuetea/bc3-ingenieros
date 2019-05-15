const cliente = document.getElementById('cliente');

if (cliente) {
  cliente.addEventListener('click', e => {
    if (e.target.className === 'btn btn-danger delete-cliente') {
      if (confirm('Are you sure?')) {
        const id = e.target.getAttribute('data-id');

        fetch('/cliente/delete/${id}', {
          method: 'DELETE'
        }).then(res => window.location.reload());
      }
    }
  });
} 
