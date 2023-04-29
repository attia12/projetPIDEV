/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package ressources;

import api.ListToPDF;
import com.jfoenix.controls.JFXButton;
import java.awt.Desktop;
import java.io.File;
import java.io.IOException;
import java.net.URL;
import java.util.Arrays;
import java.util.List;
import javafx.embed.swing.SwingFXUtils;
import javafx.event.ActionEvent;
import javafx.fxml.FXMLLoader;
import javafx.scene.Node;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Alert;
import javafx.scene.image.Image;
import javafx.scene.image.ImageView;
import javafx.scene.layout.StackPane;
import javafx.stage.FileChooser;
import javafx.stage.FileChooser.ExtensionFilter;
import javafx.stage.Stage;
import javafx.stage.StageStyle;
import javafx.stage.Window;
import javax.imageio.ImageIO;
import javax.swing.JOptionPane;

/**
 *
 * @author Nasr
 */
public class Util {
        public static Object loadWindow(URL loc, String title, Stage parentStage) {
        Object controller = null;
        try {
            FXMLLoader loader = new FXMLLoader(loc);
            Parent parent = loader.load();
            controller = loader.getController();
            Stage stage = null;
            if (parentStage != null) {
                stage = parentStage;
            } else {
                stage = new Stage(StageStyle.DECORATED);
            }
            stage.setTitle(title);
            stage.setScene(new Scene(parent));
            stage.show();
        } catch (IOException ex) {
            ex.getMessage();
        }
        return controller;
    }
        public static void showAlert(Alert.AlertType alertType, Window owner, String title, String message) {
        Alert alert = new Alert(alertType);
        alert.setTitle(title);
        alert.setHeaderText(null);
        alert.setContentText(message);
        alert.initOwner(owner);
        alert.show();
    }
    public String ImgPicker (){ 
        Stage secondStage = new Stage();
    ImageView imageView = new ImageView();
    FileChooser fc =new FileChooser() ;
     fc.getExtensionFilters().add(new ExtensionFilter("Image files (*.png)", "*.png"));
    fc.getExtensionFilters().add(new ExtensionFilter("Image files (*.jpg)","*.jpg"));
    fc.getExtensionFilters().add(new ExtensionFilter("Image files (*.jpeg)","*.jpeg"));
    fc.getExtensionFilters().add(new ExtensionFilter("Image files (*.jfif)","*.jfif"));

    File f = fc.showOpenDialog(null);

    Image image = new Image(f.toURI().toString());
               FileChooser fileChooser = new FileChooser();
               fileChooser.getExtensionFilters().add(new ExtensionFilter("Images ","*.png"));
                fileChooser.setTitle("Save Image");
                
                File file = fileChooser.showSaveDialog(secondStage);
                
                if (file != null) {
                    try {
                        ImageIO.write(SwingFXUtils.fromFXImage(image,null), "png", file);
                    } catch (IOException ex) {
                        ex.getMessage() ;
                    }

                    }

         
    if (f != null ){
         
        System.out.println(f.getAbsolutePath());
                System.out.println("the file will be uploaded here"+ file.getAbsolutePath());

    }
    
String str = file.getAbsolutePath();
		System.out.println(" we are going to take the relative from here  "+ str);
		// find word in String
		String find = "\\ressources";
		int i = str.indexOf(find);
                
		if(i>0){
                    System.out.println(str.substring(i, str.length()));
                    
			return str.substring(i, str.length());}
		else {
                    System.out.println("string not found");
			return "string not found";
                }
    }
          public static void initPDFExprot( Node contentPane, Stage stage, List<List> data) {
        FileChooser fileChooser = new FileChooser();
        fileChooser.setTitle("Save as PDF");
        FileChooser.ExtensionFilter extFilter
                = new FileChooser.ExtensionFilter("PDF files (*.pdf)", "*.pdf");
        fileChooser.getExtensionFilters().add(extFilter);
        File saveLoc = fileChooser.showSaveDialog(stage);
        ListToPDF ltp = new ListToPDF();
        boolean flag = ltp.doPrintToPdf(data, saveLoc, ListToPDF.Orientation.LANDSCAPE);
        JFXButton okayBtn = new JFXButton("Okay");
        JFXButton openBtn = new JFXButton("View File");
        openBtn.setOnAction((ActionEvent event1) -> {
            try {
                Desktop.getDesktop().open(saveLoc);
            } catch (Exception exp) {
                  JOptionPane.showMessageDialog(null,"Could not load file /n Cant load file");
            }
        });
        if (flag) {
               JOptionPane.showMessageDialog(null, "Completed /n Member data has been exported.");
        }
    }  
  
}
