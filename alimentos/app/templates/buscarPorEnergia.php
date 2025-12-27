<?php ob_start() ?>
<form name="formBusqueda" action="index.php?ctl=buscarAlimentosPorEnergia" method="post">

<!--campos de búsqueda-->
	<label for="energia_min">Energía mínima (Kcal):</label>
    <input type="number" name="energia_min" id="energia_min" 
           value="<?php echo $params['energia_min'] ?? '' ?>" min="0">
    
    <label for="energia_max">Energía máxima (Kcal):</label>
    <input type="number" name="energia_max" id="energia_max" 
           value="<?php echo $params['energia_max'] ?? '' ?>" min="0">
    
    <span></span>

	<input type="submit" value="Buscar" class="nav-btn">
</form>
<!--Tabla con los resultados encontrados-->
<?php if (count($params['resultado'])>0): ?>
	<table class="tabla-calida">
		<tr>
			<th>alimento (por 100g)</th>
			<th>energia (Kcal)</th>
			<th>grasa (g)</th>
		</tr>

		<?php foreach ($params['resultado'] as $alimento) : ?>
		<tr>
			  <!--Obtención de datos desde la BD-->
			<td><a href="index.php?ctl=ver&id=<?php echo $alimento['id'] ?>"><?php echo $alimento['nombre'] ?></a></td>
			<td><?php echo $alimento['energia'] ?></td>
			<td><?php echo $alimento['grasatotal'] ?></td>
		</tr>
		<?php endforeach; ?>
	</table>
<?php endif; ?>

<?php $contenido = ob_get_clean() ?>
<?php include 'layout.php' ?>