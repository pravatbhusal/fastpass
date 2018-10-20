import React from "react";
import {serverURL} from "../../App";
import Icon from 'react-native-vector-icons/FontAwesome';
import {StyleSheet, Text, View, Image, ImageBackground,
  Dimensions, TouchableOpacity, Alert} from "react-native";
import {ImagePicker, Permissions} from "expo";

class Home extends React.Component {
  // stack navigator's page settings
  static navigationOptions = {
  	header: null,
    title: "Home"
  }

  // open the image picker to take a picture of the customer
  async takeFaceImage(pictureOption) {
    //ask for camera permissions from the user
    await Permissions.askAsync(Permissions.CAMERA);
    await Permissions.askAsync(Permissions.CAMERA_ROLL);

    // open the camera
    let imageResult = await ImagePicker.launchCameraAsync({
      base64: true,
      quality: 0.2,
      allowsEditing: true,
      aspect: [4, 3]
    });

    // set the image and upload text to the specified option
    if(imageResult.uri !== undefined) {
      let imageData = `${imageResult.base64}`;

      // create the form data
      let formData = new FormData();
      formData.append("imageData", imageData);

      // send an HTTP Request to the server to handle the form data
      return await fetch(serverURL + "/processFace.php", {
        method: "POST",
        body: formData,
        header: {
          "content-type": "multipart/form-data",
        },
      }).then((resolved) => {
        resolved.json().then((data) => {
          // navigate to the User page with a prop of the processed face image
          var {navigate} = this.props.navigation;
          navigate("User", {data: data});
        });
      }).catch((error) => {
        Alert.alert("Oh no!", error.message);
        return;
      });
    }
  }
  render() {
    return (
      <ImageBackground source={require("../../rsrc/homebg.png")}
        style={styles.container}
        resizeMode="cover"
      >
        <View style={styles.aaTrademark}>
          <Text style={styles.aaText}>American Airlines</Text>
          <Image
            style={styles.aaLogo}
            source={require("../../rsrc/aalogo.png")}
          />
          <Text style={styles.aaText}>Fast Pass</Text>
        </View>
        <TouchableOpacity
          style={styles.openCameraButton}
          activeOpacity={0.70}
          onPress = {() => this.takeFaceImage()}
        >
          <Text style={styles.openCameraText}>Open Camera</Text>
        </TouchableOpacity>
      </ImageBackground>
    );
  }
}

// style sheet for the Home Component
const styles = StyleSheet.create({
  container: {
    flex: 1,
    flexDirection: "column",
    alignItems: "center",
    width: "100%",
    height: "100%"
  },
  aaTrademark: {
    flex: 1, // take the entire space to push the camera button to the bottom
    alignItems: "center",
    justifyContent: "center"
  },
  aaText: {
    fontSize: 35,
    fontStyle: "italic",
    color: "#FFFFFF"
  },
  aaLogo: {
    aspectRatio: 0.60,
    resizeMode: 'contain'
  },
  openCameraButton: {
    alignItems: "center",
    justifyContent: "center",
    padding: 25,
    width: Dimensions.get('window').width / 1.75,
    marginTop: 15,
    marginBottom: 15,
    borderRadius: 50,
    borderWidth: 2,
    borderColor: "#0098D4",
    backgroundColor: "#0098D4"
  },
  openCameraText: {
    fontSize: 12.5,
    fontWeight: 'bold',
    fontWeight: "bold",
    color: "#FFFFFF"
  }
});

export default Home;
