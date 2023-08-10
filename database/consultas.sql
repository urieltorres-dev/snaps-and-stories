-- Consulta para obtener las fotos/publicaciones de los usuarios que sigue 
-- un usuario y también sus publicaciones.
SELECT f.*
	FROM 
		fotos_v f
        LEFT OUTER JOIN seguidores s
			ON f.usuario_subio_id = s.usuario_siguiendo_id
	WHERE (s.usuario_seguidor_id = 2 OR f.usuario_subio_id = 2) AND f.eliminado = 0
    ORDER BY f.fecha_subido DESC;
