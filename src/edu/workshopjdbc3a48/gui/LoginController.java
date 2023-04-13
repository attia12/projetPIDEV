/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/javafx/FXMLController.java to edit this template
 */
package edu.workshopjdbc3a48.gui;

import edu.workshopjdbc3a48.entities.Admin;
import edu.workshopjdbc3a48.entities.Medecin;
import edu.workshopjdbc3a48.entities.Patient;
import edu.workshopjdbc3a48.entities.Utilisateur;
import edu.workshopjdbc3a48.services.EmailSender;
import edu.workshopjdbc3a48.services.ServiceUtilisateur;
import edu.workshopjdbc3a48.services.UserSession;
import java.io.ByteArrayInputStream;
import java.io.File;
import java.io.FileWriter;
import java.io.IOException;
import java.net.URL;
import java.security.GeneralSecurityException;
import java.sql.SQLException;
import java.util.List;
import java.util.Random;
import java.util.ResourceBundle;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.geometry.Insets;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Alert;
import javafx.scene.control.Alert.AlertType;
import javafx.scene.control.Button;
import javafx.scene.control.CheckBox;
import javafx.scene.control.Label;
import javafx.scene.control.TextField;
import javafx.scene.image.Image;
import javafx.scene.image.ImageView;
import javafx.scene.layout.HBox;
import javafx.stage.Modality;
import javafx.stage.Stage;
import javax.mail.MessagingException;
import org.opencv.core.Core;
import org.opencv.core.Mat;
import org.opencv.core.MatOfByte;
import org.opencv.core.MatOfRect;
import org.opencv.core.Rect;
import org.opencv.core.Scalar;
import org.opencv.core.Size;
import org.opencv.imgcodecs.Imgcodecs;
import org.opencv.imgproc.Imgproc;
import org.opencv.objdetect.CascadeClassifier;
import org.opencv.videoio.VideoCapture;

/**
 * FXML Controller class
 *
 * @author user
 */
public class LoginController implements Initializable {
 private static final String CASCADE_CLASSIFIER_FILE = "C:\\opencv\\sources\\samples\\winrt_universal\\VideoCaptureXAML\\video_capture_xaml\\video_capture_xaml.Windows\\Assets\\haarcascade_frontalface_alt.xml";
    private static final String KNOWN_FACE_FILE = "C:\\knownFaces\\Known1.png";
    private static final int IMAGE_WIDTH = 200;
    private static final int IMAGE_HEIGHT = 200;

    private CascadeClassifier faceDetector;
    private ImageView capturedImageView;
     private ImageView capturedImageView2;
    private Label statusLabel;
    private Mat capturedImage;
    private Mat knownFace;
private  List<Utilisateur> l = null ;
    @FXML
    private TextField tf_email;
    @FXML
    private TextField tf_mdp;
    @FXML
    private Button btn_val;
    @FXML
    private Button inscriptionbtn;
    @FXML
    private Button mdp_oublie;
    @FXML
    private Button btn_google;
    @FXML
    private Button btn_face;
    @FXML
    private ImageView logo;
    @FXML
    private ImageView img_font;
    @FXML
    private ImageView Email_img;
    @FXML
    private ImageView pass_img;
    @FXML
    private CheckBox r_c;

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
  //   Image image = new Image(getClass().getResourceAsStream("C:\\knownFaces\\l.png"));
    // logo.setImage(image);  // TODO
 //    File file = new File("‪‪‪C:\\knownFaces\\l.png");
//Image image = new Image(file.toURI().toString());
//logo.setImage(image);
File file = new File("C:\\knownFaces\\l.png");
if(file.exists()) {
    Image image = new Image(file.toURI().toString());
    logo.setImage(image);
} else {
    System.out.println("Image file not found!");
}

File file2 = new File("C:\\knownFaces\\font.png");
if(file.exists()) {
    Image image2 = new Image(file2.toURI().toString());
    img_font.setImage(image2);
} else {
    System.out.println("Image file not found!");
}
File file3 = new File("C:\\knownFaces\\mail.png");
if(file.exists()) {
    Image image3 = new Image(file3.toURI().toString());
    Email_img.setImage(image3);
} else {
    System.out.println("Image file not found!");
}
    }    

    @FXML
    private void Login(ActionEvent event) throws SQLException {
        Utilisateur user = new Utilisateur();
        ServiceUtilisateur su=new ServiceUtilisateur();
        if (su.checkLogin(tf_email.getText(), tf_mdp.getText()))
        { Random rand = new Random();
        int randomNumber = rand.nextInt(10000);
    
           user= su.Login(tf_email.getText(), tf_mdp.getText());
           
    if ("Admin".equals(user.getType()))
    { Utilisateur u=new Admin();
    u=user;
           UserSession.getInstance().setCurrentUser(u);}
    else if ("Medecin".equals(user.getType()))
    { Utilisateur u=new Medecin();
    u=user;
           UserSession.getInstance().setCurrentUser(u);}
    else if ("Patient".equals(user.getType()))
    { Utilisateur u=new Patient();
    u=user;
           UserSession.getInstance().setCurrentUser(u);}
    if (r_c.isSelected())
    {
    
      String fileName = "data.txt";
        String data = Integer.toString(user.getId());

        try {
          try (FileWriter writer = new FileWriter(fileName)) {
              writer.write(data);
              System.out.println("Data written to file.");
          }
            
        } catch (IOException e) {
            System.out.println("Error writing to file.");
        }
    
    
    }
    else {String fileName = "data.txt";
        String data = "";

        try {
          try (FileWriter writer = new FileWriter(fileName)) {
              writer.write(data);
              System.out.println("Data written to file.");
          }
            
        } catch (IOException e) {
            System.out.println("Error writing to file.");
        }}
               user.setCode(randomNumber);
           if (user.getEtat()==0)
           { Alert alert = new Alert(AlertType.INFORMATION);
alert.setTitle("Alerte");
alert.setHeaderText(null);
alert.setContentText("Merci de verifier votre boite E-mail pour valider votre compte !");
alert.showAndWait();
 try {
            
            
            
    EmailSender.sendEmail(user.getEmail(), "Activation compte", "Bonjour "+user.getNom() + " " + user.getPrenom()+ " A fin d'activer votre compte merci d'utiliser ce code : "+user.getCode());
    System.out.println("Email sent successfully!");
} catch (MessagingException ex) {
    System.out.println("Failed to send email: " + ex.getMessage());
}
 FXMLLoader loader = new FXMLLoader(getClass().getResource("Verficationcompte.fxml"));
            Parent root = null;
            try {
                root = loader.load();
            } catch (IOException ex) {
                Logger.getLogger(AfficherUserController.class.getName()).log(Level.SEVERE, null, ex);
            }
      
          
            Scene scene = new Scene(root);
            Stage stage = new Stage();
            stage.setScene(scene);
          stage.show();
          Stage stage1 = (Stage) btn_val.getScene().getWindow(); 
         stage1.close();
           }
           else
           {
           
           
           
           
          FXMLLoader loader = new FXMLLoader(getClass().getResource("AfficherUser.fxml"));
            Parent root = null;
            try {
                root = loader.load();
            } catch (IOException ex) {
                Logger.getLogger(AfficherUserController.class.getName()).log(Level.SEVERE, null, ex);
            }
            AfficherUserController controller = loader.getController();
      
          
            Scene scene = new Scene(root);
            Stage stage = new Stage();
            stage.setScene(scene);
          stage.show();
          Stage stage1 = (Stage) btn_val.getScene().getWindow(); // get the current stage
         stage1.close();}
        }
        else {
        Alert alert = new Alert(AlertType.INFORMATION);
alert.setTitle("Alerte");
alert.setHeaderText(null);
alert.setContentText("Merci de verifier vos coordonneés !");
alert.showAndWait();
        
        }
        
        
        
    }

    @FXML
    private void Inscrit(ActionEvent event) {
         FXMLLoader loader = new FXMLLoader(getClass().getResource("Signup.fxml"));
            Parent root = null;
            try {
                root = loader.load();
            } catch (IOException ex) {
                Logger.getLogger(AfficherUserController.class.getName()).log(Level.SEVERE, null, ex);
            }
           SignupController controller = loader.getController();
      
          
            Scene scene = new Scene(root);
            Stage stage = new Stage();
            stage.setScene(scene);
          stage.show();
          Stage stage1 = (Stage) btn_val.getScene().getWindow(); 
         stage1.close();
    }

    @FXML
    private void mdp_oublie(ActionEvent event) {
           FXMLLoader loader = new FXMLLoader(getClass().getResource("Mdp_oublie.fxml"));
            Parent root = null;
            try {
                root = loader.load();
            } catch (IOException ex) {
                Logger.getLogger(AfficherUserController.class.getName()).log(Level.SEVERE, null, ex);
            }
      
          
            Scene scene = new Scene(root);
            Stage stage = new Stage();
            stage.setScene(scene);
            stage.show();
     Stage stage1 = (Stage) btn_val.getScene().getWindow(); 
         stage1.close();
    }

    @FXML
    private void GoogleLogin(ActionEvent event) throws GeneralSecurityException, IOException {
        Google g =new Google();
        g.performOAuth2();
        Stage stage1 = (Stage) btn_val.getScene().getWindow(); 
         stage1.close();
    
}

    @FXML
    private void Face(ActionEvent event) {
         // Create the capture window
          System.loadLibrary(Core.NATIVE_LIBRARY_NAME);

        // Load the face detector
        faceDetector = new CascadeClassifier(CASCADE_CLASSIFIER_FILE);

        Stage captureWindow = new Stage();
        
        captureWindow.initModality(Modality.APPLICATION_MODAL);
        captureWindow.setTitle("Capture Face");

        // Create the UI for the capture window
        capturedImageView = new ImageView();
        Button captureImageButton = new Button("Capture");
        captureImageButton.setOnAction(e -> {
            // Capture the image from the webcam
            VideoCapture capture = new VideoCapture(0);
            Mat image = new Mat();
            capture.read(image);

            // Display the captured image
            capturedImageView.setImage(mat2Image(image));
//capturedImageView2.setImage(mat2Image(knownFace));
            // Detect faces in the captured image
            MatOfRect faceDetections = new MatOfRect();
            faceDetector.detectMultiScale(image, faceDetections);

            if (faceDetections.toArray().length == 0) {
             //   statusLabel.setText("No face detected");
                return;
            }

            // Extract the first face detected
            Rect face = faceDetections.toArray()[0];
            Mat faceImage = new Mat(image, face);

            // Resize the face image to a standard size
           // Imgproc.resize(faceImage, faceImage, new Size(IMAGE_WIDTH, IMAGE_HEIGHT));
            //Imgproc.cvtColor(faceImage, faceImage, Imgproc.COLOR_BGR2GRAY);

            // Compare the captured face to the known face
                ServiceUtilisateur su=new ServiceUtilisateur();
            l=su.getAll();
            int i=0;
             Utilisateur u = new Utilisateur();
             boolean check=false;
           while(i<l.size()&&(check==false)){
             u=l.get(i);
          
              knownFace=Imgcodecs.imread(u.getFace());
             //  System.out.println(knownFace);
              // System.out.println(faceImage);
            if (compareFaces(faceImage, knownFace)) {
               statusLabel.setText("Face recognized");
              check=true;
              UserSession.getInstance().setCurrentUser(u);
                System.out.println("Worked");
          FXMLLoader loader = new FXMLLoader(getClass().getResource("AfficherUser.fxml"));
            Parent root = null;
            try {
                root = loader.load();
            } catch (IOException ex) {
                Logger.getLogger(AfficherUserController.class.getName()).log(Level.SEVERE, null, ex);
            }
      
          
            Scene scene = new Scene(root);
            Stage stage = new Stage();
            stage.setScene(scene);
          stage.show();
                
                 Stage stage2 = (Stage) capturedImageView.getScene().getWindow(); 
         stage2.close();
                Stage stage1 = (Stage) btn_val.getScene().getWindow(); 
         stage1.close();
         
                
} else {
//statusLabel.setText("Face not recognized");
 System.out.println("not Worked");
}
           // Release the video capture
        capture.release();
  i++;  }
        });

    HBox hbox = new HBox(10, capturedImageView, captureImageButton);
    hbox.setPadding(new Insets(10));

    Scene scene = new Scene(hbox);

    captureWindow.setScene(scene);
    captureWindow.show();
    }
    private boolean compareFaces(Mat face1, Mat face2) {
   
        if (compareImages(face1, face2)) {
            // Face recognized, do something with user data
            System.out.println("Face recognized for user: ");
            return true;
        
    }

    // Face not recognized
    System.out.println("Face not");
    return false;
}


private Image mat2Image(Mat mat) {
    // Convert the Mat object to an Image object
    return Utils.mat2Image(mat);
}     
private boolean compareImages(Mat image1, Mat image2) {
    // Convert the images to grayscale
    Mat grayImage1 = new Mat();
    Mat grayImage2 = new Mat();
    Imgproc.cvtColor(image1, grayImage1, Imgproc.COLOR_BGR2GRAY);
    Imgproc.cvtColor(image2, grayImage2, Imgproc.COLOR_BGR2GRAY);

    // Detect faces in the images
    MatOfRect faceDetections1 = new MatOfRect();
    faceDetector.detectMultiScale(grayImage1, faceDetections1);
    MatOfRect faceDetections2 = new MatOfRect();
    faceDetector.detectMultiScale(grayImage2, faceDetections2);

    // Return false if no faces are detected in either image
    if (faceDetections1.toArray().length == 0 || faceDetections2.toArray().length == 0) {
        return false;
    }

    // Extract the first face detected in each image
    Rect face1 = faceDetections1.toArray()[0];
    Rect face2 = faceDetections2.toArray()[0];
    Mat croppedFace1 = new Mat(grayImage1, face1);
    Mat croppedFace2 = new Mat(grayImage2, face2);

    // Resize the faces to a standard size
    Imgproc.resize(croppedFace1, croppedFace1, new Size(IMAGE_WIDTH, IMAGE_HEIGHT));
    Imgproc.resize(croppedFace2, croppedFace2, new Size(IMAGE_WIDTH, IMAGE_HEIGHT));

    // Calculate the difference between the faces
    Mat diff = new Mat();
    Core.absdiff(croppedFace1, croppedFace2, diff);

    // Calculate the average pixel value difference
    Scalar mean = Core.mean(diff);
    double avgDiff = mean.val[0];

    // Return true if the difference is below a threshold
    return avgDiff < 20;
}

}

class Utils {
public static Image mat2Image(Mat mat) {
// Convert the Mat object to a byte array
MatOfByte byteMat = new MatOfByte();
Imgcodecs.imencode(".png", mat, byteMat);
byte[] byteArray = byteMat.toArray();
    // Convert the byte array to an Image object
    Image image = new Image(new ByteArrayInputStream(byteArray));

    return image;
}
}

