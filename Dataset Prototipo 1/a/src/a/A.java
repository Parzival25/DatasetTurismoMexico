/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Main.java to edit this template
 */
package a;
import java.io.File;
import java.io.FileNotFoundException;
import java.util.Scanner;
import javax.xml.parsers.ParserConfigurationException;
import javax.xml.transform.TransformerException;
//
import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.IOException;
import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;
import javax.xml.parsers.ParserConfigurationException;
import javax.xml.transform.Result;
import javax.xml.transform.Source;
import javax.xml.transform.Transformer;
import javax.xml.transform.TransformerException;
import javax.xml.transform.TransformerFactory;
import javax.xml.transform.dom.DOMSource;
import javax.xml.transform.stream.StreamResult;
import org.w3c.dom.DOMImplementation;
import org.w3c.dom.Document;
import org.w3c.dom.Element;
import org.w3c.dom.Text;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.nio.file.FileSystems;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.StandardCopyOption;

/**
 *
 * @author EDUAR
 */
public class A {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args){
        // TODO code application logic here
        int salirWhile=0;
        int salirWhile2=0;
        String texto;
        for (int i = 1; i < 140; i++) {
//-------------------------------------------------------------------------------------------------------------------------------------------------
            try {         
                
                //Lee el atomo
                File doc = new File("D:\\Residencia\\Dataset Prototipo 1\\turismo_chiapas\\atomos\\"+i+".html");
                Scanner obj = new Scanner(doc);
                //Crea directorio
                File directorio = new File("D:\\Residencia\\Dataset Prototipo 1\\turismo_chiapas\\atomos\\"+i);
                
                if (!directorio.exists()) {
                    
                    if (directorio.mkdirs()) {
//                        System.out.println("Directorio creado");
//-------------------------------------------------------------------------------------------------------------------------------------------------
//                        // Creo una instancia de DocumentBuilderFactory
//                        DocumentBuilderFactory factory = DocumentBuilderFactory.newInstance();
//                        // Creo un documentBuilder
//                        DocumentBuilder builder = factory.newDocumentBuilder();
//                        // Creo un DOMImplementation
//                        DOMImplementation implementation = builder.getDOMImplementation();
//                        // Creo un documento con un elemento raiz
//                        Document documento = implementation.createDocument(null, "Atomo", null);
//                        documento.setXmlVersion("1.0");
                        
                       // Creo una instancia de DocumentBuilderFactory
                        DocumentBuilderFactory factory = DocumentBuilderFactory.newInstance();
                        // Creo un documentBuilder
                        DocumentBuilder builder = factory.newDocumentBuilder();
                        // Creo un DOMImplementation
                        DOMImplementation implementation = builder.getDOMImplementation();

                        // Creo un documento con un elemento raiz
                        Document documento = implementation.createDocument(null, "Atomo", null);
                        documento.setXmlVersion("1.0");
                        
//-------------------------------------------------------------------------------------------------------------------------------------------------
                        
                        // Creo los elementos
                        Element id = documento.createElement("id");           
                        documento.getDocumentElement().appendChild(id);
                        Text textId = documento.createTextNode(String.valueOf(i));
                        id.appendChild(textId);
                        
                        Element nombre = documento.createElement("Nombre");           
                        documento.getDocumentElement().appendChild(nombre);
                        Text textnombre;
                        
                        Element descripcion = documento.createElement("Descripcion");           
                        documento.getDocumentElement().appendChild(descripcion);
                        Text textdescripciones;
                        
                        Element  localizacion = documento.createElement("Localizacion");           
                        documento.getDocumentElement().appendChild(localizacion);
                        Text textlocalizacion;
                        
                        Element  comollegar = documento.createElement("Comollegar");           
                        documento.getDocumentElement().appendChild(comollegar);
                        Text textcomollegart;
                        
                        Element  actividades = documento.createElement("Actividades");           
                        documento.getDocumentElement().appendChild(actividades);
                        
                        Element  coordenadas = documento.createElement("Coordenadas");           
                        documento.getDocumentElement().appendChild(coordenadas);
                        
                        
                        
//                        Element  xd = documento.createElement("xd");           
//                        documento.getDocumentElement().appendChild(xd);
//                        Text textxd;
//-------------------------------------------------------------------------------------------------------------------------------------------------
                        while (obj.hasNextLine()){
                            texto =String.valueOf(obj.nextLine());                                
//*************************************************************
                            //Obtener el texto del titulo
                            if((-1)!=texto.indexOf("titulo")){
                                textnombre = documento.createTextNode(texto.substring(texto.indexOf(">")+1 ,texto.indexOf("</")));
                                nombre.appendChild(textnombre);                  
                            }
//*************************************************************
                            //Obtener el texto de la descripcion
                            if(  ((-1)!=texto.indexOf("<div id=\"tab1\" class=\"tab_content\">" )) || ((-1)!=texto.indexOf("<div id=\"tab29\" class=\"tab_content\">" ))  ){

                                while (obj.hasNextLine()&&(salirWhile==0)){
                                    texto =String.valueOf(obj.nextLine());
                                    
                                    textdescripciones = documento.createTextNode(texto.substring(texto.indexOf("p>")+2 ,texto.indexOf("</")));
                                    descripcion.appendChild(textdescripciones);     
                                    if((-1)!=texto.indexOf("</div>")){                         
                                        salirWhile=1;
                                    }
                                }                 
                            }                    
//*************************************************************
                            //Obtener el texto de la localizacion
                            if((-1)!=texto.indexOf(" <div id=\"tab2\" class=\"tab_content\">")|| ((-1)!=texto.indexOf("<div id=\"tab30\" class=\"tab_content\">" ))){
//                                System.out.println("Localizacion");

                                while (obj.hasNextLine()&&(salirWhile==0)){
                                    texto =String.valueOf(obj.nextLine());

                                    
                                    textlocalizacion = documento.createTextNode( texto.substring(texto.indexOf("p>")+2 ,texto.indexOf("</")));
                                    localizacion.appendChild(textlocalizacion);
//                                    System.out.println(texto.substring(texto.indexOf("p>")+2 ,texto.indexOf("</")));

                                    if((-1)!=texto.indexOf("</div>")){                         
                                        salirWhile=1;
                                    }                         
                                }
                            }                    
//*************************************************************
                            // Obtener el texto de como llegar
                            if((-1)!=texto.indexOf("<div id=\"tab3\" class=\"tab_content\">")|| ((-1)!=texto.indexOf("<div id=\"tab31\" class=\"tab_content\">" ))){
//                                System.out.println("Como llegar");

                                while (obj.hasNextLine()&&(salirWhile==0)){
                                    texto =String.valueOf(obj.nextLine());

                                    if((-1)!=texto.indexOf("</div>")){
                                        salirWhile=1;
                                    }else{
                                        if((-1)!=texto.indexOf("<p>")){  
                                            textcomollegart =  documento.createTextNode(texto.substring(texto.indexOf("p>")+2 ,texto.indexOf("</")));
                                            comollegar.appendChild(textcomollegart);
//                                             System.out.println(texto.substring(texto.indexOf("p>")+2 ,texto.indexOf("</")));
                                        }
                                    }
                                }                 
                            }       
                            salirWhile=0;
//*************************************************************
                            //Obtener el texto de las actividades
                            if((-1)!=texto.indexOf("<div id=\"tab4\" class=\"tab_content\">")|| ((-1)!=texto.indexOf("<div id=\"tab32\" class=\"tab_content\">" ))){
//                                System.out.println("Actividades");

                                while (obj.hasNextLine()&&(salirWhile==0)){
                                    texto =String.valueOf(obj.nextLine());

                                    if((-1)!=texto.indexOf("</div>")){                         
                                        salirWhile=1;
                                    }else{

                                        if((-1)!=texto.indexOf("<p>")){  
                                            if( (-1)!=texto.indexOf("*")){
                                                Element actividad = documento.createElement("Actividad");
                                                Text textactividad = documento.createTextNode(texto.substring(texto.indexOf("p>")+2 ,texto.indexOf("</")));
                                                actividad.appendChild(textactividad);
                                                actividades.appendChild(actividad);
                                            }
                                            
                                       // System.out.println(texto.substring(texto.indexOf("p>")+2 ,texto.indexOf("</")));
                                        }
                                    }
                                }    
                            }  
                            salirWhile=0;
//*************************************************************
                            
                            
                            //Obtener rutas de las imagenes
                            if((-1)!=texto.indexOf("<span><br/><img src=")){
//                                System.out.println(texto.substring(texto.indexOf("src=\"")+5 ,texto.indexOf("\"/>")));
                                String origenText ="D:\\Residencia\\Dataset Prototipo 1\\turismo_chiapas" + texto.substring(texto.indexOf("src=\"")+7 ,texto.indexOf("\"/>"));
                                File origen = new File(origenText);
                                String destinoText = "D:\\Residencia\\Dataset Prototipo 1\\turismo_chiapas\\atomos\\"+ i+texto.substring(texto.indexOf("src=\"")+13 ,texto.indexOf("\"/>"));
                                File destino = new File(destinoText);

                                try {
                                    
                                        InputStream in = new FileInputStream(origen);
                                        OutputStream out = new FileOutputStream(destino);

                                        byte[] buf = new byte[1024];
                                        int len;

                                        while ((len = in.read(buf)) > 0) {
                                                out.write(buf, 0, len);
                                        }

                                        in.close();
                                        out.close();
                                } catch (IOException ioe){
                                        ioe.printStackTrace();
                                }
                            }
                            //System.out.println(texto);
                            salirWhile=0;
                            }
    
//*************************************************************
                           
                            XPathReader crear = new XPathReader();
                            String lat = XPathReader.localizaciones.get(i).getLatitud();
                            String lng = XPathReader.localizaciones.get(i).getLongitud();
                            
                            Element latitud = documento.createElement("Latitud");
                            Text textlatitud = documento.createTextNode(lat);
                            latitud.appendChild(textlatitud);
                            coordenadas.appendChild(latitud);
                            
                            Element longitud = documento.createElement("Longitud");
                            Text textlongitud = documento.createTextNode(lng);
                            longitud.appendChild(textlongitud);
                            coordenadas.appendChild(longitud);
                            
//*************************************************************
 //-------------------------------------------------------------------------------------------------------------------------------------------------
                   
                        
//                            // Asocio el source con el Document
//                            Source source = new DOMSource(documento);
//                            // Creo el Result, indicado que fichero se va a crear
//                            Result result = new StreamResult(new File("Atomo.xml"));
//
//                            // Creo un transformer, se crea el fichero XML
//                            Transformer transformer = TransformerFactory.newInstance().newTransformer();
//                            transformer.transform(source, result);
// 
                            // Asocio el source con el Document
                            Source source = new DOMSource(documento);
                            // Creo el Result, indicado que fichero se va a crear
                            Result result = new StreamResult(new File("Atomo.xml"));

                            // Creo un transformer, se crea el fichero XML
                            Transformer transformer = TransformerFactory.newInstance().newTransformer();
                            transformer.transform(source, result);
                        
                        
    //-------------------------------------------------------------------------------------------------------------------------------------------------
//                        Path origenPath = FileSystems.getDefault().getPath("D:\\Imagenes\\00000-0000-00.png");
//                        Path destinoPath = FileSystems.getDefault().getPath("D:\\Imagenes\\borrar\\ejemplo1.png");
    //-------------------------------------------------------------------------------------------------------------------------------------------------
      try {
                                    
                                        InputStream in2 = new FileInputStream("D:\\Residencia\\Dataset Prototipo 1\\a\\Atomo.xml");
                                        OutputStream out2 = new FileOutputStream("D:\\Residencia\\Dataset Prototipo 1\\turismo_chiapas\\atomos\\"+i+"\\Atomo.xml");

                                        byte[] buf = new byte[1024];
                                        int len;

                                        while ((len = in2.read(buf)) > 0) {
                                                out2.write(buf, 0, len);
                                        }

                                        in2.close();
                                        out2.close();
                                } catch (IOException ioe){
                                        ioe.printStackTrace();
                                }
    
    //-----------------------------------------------------------------------------------------------------------------------------------------------------
                    } else {
                        System.out.println("Error al crear directorio");
                    }
                }                
            }catch (FileNotFoundException ex) {
                System.out.println("Archivo "+i+" no encontrado");
            }catch (ParserConfigurationException | TransformerException ex) {
                System.out.println("Problema en atomo "+i+" ");
            }catch (IOException e) {
                 System.out.println("Problema en atomo "+i+" ");
            }
        } 
    }   
}
