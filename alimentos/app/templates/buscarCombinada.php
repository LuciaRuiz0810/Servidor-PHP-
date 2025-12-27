<?php ob_start() ?>
<h3>Búsqueda Combinada</h3>

<form name="formBusquedaCombinada" action="index.php?ctl=buscarAlimentosCombinada" method="post">
   
<!--campos de búsqueda-->
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" id="nombre" 
           value="<?php echo $params['nombre'] ?? '' ?>">
    
    <label for="energia_min">Energía mínima:</label>
    <input type="number" name="energia_min" id="energia_min" 
           value="<?php echo $params['energia_min'] ?? '' ?>" min="0">
    
    <label for="energia_max">Energía máxima:</label>
    <input type="number" name="energia_max" id="energia_max" 
           value="<?php echo $params['energia_max'] ?? '' ?>" min="0">
   
    <label for="proteina_min">Proteína mínima (g):</label>
    <input type="number" name="proteina_min" id="proteina_min" 
           value="<?php echo $params['proteina_min'] ?? '' ?>" step="0.1" min="0">
    
    <br><br>
    <input type="submit" value="Buscar Combinada" class="nav-btn">
</form>

<!--Tabla con los resultados encontrados-->
<?php if (isset($params['resultado']) && count($params['resultado']) > 0): ?>
    <table class="tabla-calida">
        <tr>
            <th>alimento (por 100g)</th>
            <th>energia (Kcal)</th>
            <th>grasa (g)</th>
             <th>Proteína</th>
        </tr>
        
        <?php foreach ($params['resultado'] as $alimento) : ?>
        <tr>
        <!--Obtención de datos desde la BD-->
            <td><a href="index.php?ctl=ver&id=<?php echo $alimento['id'] ?>">
                <?php echo $alimento['nombre'] ?></a></td>
            <td><?php echo $alimento['energia'] ?></td>
            <td><?php echo $alimento['grasatotal'] ?></td>
            <td><?php echo $alimento['proteina'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php elseif (isset($params['resultado'])): ?>
    <p>No se encontraron alimentos con esos criterios combinados.</p>
<?php endif; ?>

<?php $contenido = ob_get_clean() ?>
<?php include 'layout.php' ?>