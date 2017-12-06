using UnityEngine;
using System.Collections;

public class joinGame_click : MonoBehaviour {
    public GameObject ws;
    public int rnd;
	// Use this for initialization
	void Start () {
        //GameObject waitS = GameObject.FindGameObjectWithTag("waitScreen");
        //waitS.SetActive(true);
        rnd = 1;
    }
	
	// Update is called once per frame
	public void butpress () {
        //GameObject waitS = GameObject.FindGameObjectWithTag("waitScreen");
        ws.SetActive(true);

    }

    public int getRnd()
    {
        return rnd;
    }
    public void setRnd()
    {
        rnd ++;
    }
    
}
