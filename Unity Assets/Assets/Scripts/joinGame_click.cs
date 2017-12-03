using UnityEngine;
using System.Collections;

public class joinGame_click : MonoBehaviour {
    public GameObject ws;
	// Use this for initialization
	void Start () {
        //GameObject waitS = GameObject.FindGameObjectWithTag("waitScreen");
        //waitS.SetActive(true);

    }
	
	// Update is called once per frame
	public void butpress () {
        //GameObject waitS = GameObject.FindGameObjectWithTag("waitScreen");
		string url = "https://purduebalderdash.000webhostapp.com/php/gameFunctionCall.php";
		WWWForm form = new WWWForm ();
		form.AddField("functionName", "join_game");
		WWW www = new WWW(url, form);
		yield return www;
        ws.SetActive(true);

    }
}
