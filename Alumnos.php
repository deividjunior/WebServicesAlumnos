<?php

/**
 * Representa el la estructura de las alumnoss
 * almacenadas en la base de datos
 */
require 'Database.php';

class alumnos
{
    function __construct()
    {
    }

    /**
     * Retorna en la fila especificada de la tabla 'alumnos'
     *
     * @param $idAlumno Identificador del registro
     * @return array Datos del registro
     */
    public static function getAll()
    {
        $consulta = "SELECT * FROM alumnos";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute();

            return $comando->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Obtiene los campos de un Alumno con un identificador
     * determinado
     *
     * @param $idAlumno Identificador del alumno
     * @return mixed
     */
    public static function getById($idAlumno)
    {
        // Consulta de la tabla alumnos
        $consulta = "SELECT idAlumno,
                            nombre,
                            direccion
                             FROM alumnos
                             WHERE idAlumno = ?";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idAlumno));
            // Capturar primera fila del resultado
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;

        } catch (PDOException $e) {
            // Aqu� puedes clasificar el error dependiendo de la excepci�n
            // para presentarlo en la respuesta Json
            return -1;
        }
    }

    /**
     * Actualiza un registro de la bases de datos basado
     * en los nuevos valores relacionados con un identificador
     *
     * @param $idAlumno      identificador
     * @param $nombre      nuevo nombre
     * @param $direccion nueva direccion
     
     */
    public static function update(
        $idAlumno,
        $nombre,
        $direccion
    )
    {
        // Creando consulta UPDATE
        $consulta = "UPDATE alumnos" .
            " SET nombre=?, direccion=? " .
            "WHERE idAlumno=?";

        // Preparar la sentencia
        $cmd = Database::getInstance()->getDb()->prepare($consulta);

        // Relacionar y ejecutar la sentencia
        $cmd->execute(array($nombre, $direccion, $idAlumno));

        return $cmd;
    }

    /**
     * Insertar un nuevo Alumno
     *
     * @param $nombre      nombre del nuevo registro
     * @param $direccion direcci�n del nuevo registro
     * @return PDOStatement
     */
    public static function insert(
        $nombre,
        $direccion
    )
    {
        // Sentencia INSERT
        $comando = "INSERT INTO alumnos ( " .
            "nombre," .
            " direccion)" .
            " VALUES( ?,?)";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(
            array(
                $nombre,
                $direccion
            )
        );

    }

    /**
     * Eliminar el registro con el identificador especificado
     *
     * @param $idAlumno identificador de la tabla alumnos
     * @return bool Respuesta de la eliminaci�n
     */
    public static function delete($idAlumno)
    {
        // Sentencia DELETE
        $comando = "DELETE FROM alumnos WHERE idAlumno=?";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(array($idAlumno));
    }
}

?>