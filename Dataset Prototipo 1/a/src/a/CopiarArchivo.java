/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package a;

import java.io.IOException;
import java.nio.file.FileSystems;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.StandardCopyOption;
/**
 *
 * @author EDUAR
 */
public class CopiarArchivo {
     public static void main(String[] args) {


        try {
            
        Path origenPath = FileSystems.getDefault().getPath("D:\\Imagenes\\00000-0000-00.png");
        Path destinoPath = FileSystems.getDefault().getPath("D:\\Imagenes\\borrar\\ejemplo1.png");
        
            Files.copy(origenPath, destinoPath, StandardCopyOption.REPLACE_EXISTING);
        } catch (IOException e) {
            System.err.println(e);
        }

    }

}
